<?php

use console\components\Migration;
use \yii\helpers\ArrayHelper;
use \yii\base\Exception;

class m151101_162310_migrateCars extends Migration
{
    public function up()
    {
        try {
            $this->_createTableCarFirm();
        } catch (Exception $e) {
        }

        try {
            $this->_createTableCarModel();
        } catch (Exception $e) {
        }

        try {
            $this->_createTableCarBody();
        } catch (Exception $e) {
        }

        try {
            $this->_createTableCarMotor();
        } catch (Exception $e) {
        }

        $this->_insertData();
    }

    public function down()
    {
        $foreignKeys = [
            'fk_car_model_car_firm_id'  => 'car_model',
            'fk_car_body_car_firm_id'   => 'car_body',
            'fk_car_body_car_model_id'  => 'car_body',
            'fk_car_motor_car_firm_id'  => 'car_motor',
            'fk_car_motor_car_model_id' => 'car_motor',
            'fk_car_motor_car_body_id'  => 'car_motor'
        ];
        foreach ($foreignKeys as $key => $table) {
            try {
                $this->dropForeignKey($key, $table);
            } catch (Exception $e) {
            }
        }

        $tables = [
            'car_motor',
            'car_body',
            'car_model',
            'car_firm'
        ];
        foreach ($tables as $table) {
            try {
                $this->dropTable($table);
            } catch (Exception $e) {
            }
        }
    }

    private function _createTableCarFirm()
    {
        $this->createTable('car_firm', [
            'id'          => self::PRIMARY_KEY,
            'name'        => 'VARCHAR(100) NOT NULL',
            'import'      => 'TINYINT(1) UNSIGNED DEFAULT 1',
            'date_create' => self::DATE_FIELD
        ], self::TABLE_OPTIONS);
    }

    private function _createTableCarModel()
    {
        $this->createTable('car_model', [
            'id'          => self::PRIMARY_KEY,
            'name'        => 'VARCHAR(100) NOT NULL',
            'car_firm_id' => self::INT_FIELD . ' NOT NULL',
            'date_create' => self::DATE_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_car_model_car_firm_id', 'car_model', 'car_firm_id',
            'car_firm', 'id', 'CASCADE', 'CASCADE');
    }

    private function _createTableCarBody()
    {
        $this->createTable('car_body', [
            'id'           => self::PRIMARY_KEY,
            'name'         => 'VARCHAR(100) NOT NULL',
            'car_firm_id'  => self::INT_FIELD . ' NOT NULL',
            'car_model_id' => self::INT_FIELD . ' NOT NULL',
            'date_create'  => self::DATE_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_car_body_car_firm_id', 'car_body', 'car_firm_id',
            'car_firm', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_car_body_car_model_id', 'car_body', 'car_model_id',
            'car_model', 'id', 'CASCADE', 'CASCADE');
    }

    private function _createTableCarMotor()
    {
        $this->createTable('car_motor', [
            'id'           => self::PRIMARY_KEY,
            'name'         => 'VARCHAR(100) NOT NULL',
            'car_firm_id'  => self::INT_FIELD . ' NOT NULL',
            'car_model_id' => self::INT_FIELD . ' NOT NULL',
            'car_body_id'  => self::INT_FIELD . ' NOT NULL',
            'date_create'  => self::DATE_FIELD
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_car_motor_car_firm_id', 'car_motor', 'car_firm_id',
            'car_firm', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_car_motor_car_model_id', 'car_motor', 'car_model_id',
            'car_model', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_car_motor_car_body_id', 'car_motor', 'car_body_id',
            'car_body', 'id', 'CASCADE', 'CASCADE');
    }

    private function _insertData()
    {
        $curl = Yii::$app->curl;

        $url
            = 'http://baza.drom.ru/ajax-control/modelSelectControl/mselect?ajax=1&super-edit=1&mode=control&bodyNumbers=&engineNumbers=';
        $carFirms = mb_convert_encoding($curl->get($url), 'UTF-8', 'CP1251');
        $data = @json_decode($carFirms, true);
        $result = ArrayHelper::getValue($data, 'response.levels.0.items', []);

        $our = [
            'Лада',
            'ГАЗ',
            'ЗАЗ',
            'ИЖ',
            'ЛУАЗ',
            'Москвич',
            'Прочие авто',
            'ТагАЗ',
            'УАЗ',
        ];

        $connect = Yii::$app->db;
        $date = date('Y-m-d H:i:s');

        foreach ($result as $firmK => $itemFirm) {
            echo 'car firm ' . $itemFirm['name'] . PHP_EOL;

            $import = array_search($itemFirm['name'], $our) === false ? 1 : 2;
            $connect->createCommand()->insert('car_firm', [
                'name'        => $itemFirm['name'],
                'import'      => $import,
                'date_create' => $date
            ])->execute();
            $firmId = $connect->getLastInsertID();

            if (empty($itemFirm['has_children'])) {
                continue;
            }

            $urlModel = 'http://baza.drom.ru/ajax-control/modelSelectControl/mselect?mode=models&firm='
                . $itemFirm['name'];
            $carModels = mb_convert_encoding($curl->get($urlModel), 'UTF-8', 'CP1251');
            if (empty($carModels)) {
                continue;
            }

            try {
                $dataModels = @json_decode($carModels, true);
            } catch (Exception $e) {
                continue;
            }

            $resultModels = ArrayHelper::getValue($dataModels, 'response.items', []);

            foreach ($resultModels as $modelK => $itemModel) {
                echo 'car model ' . $itemModel['name'] . PHP_EOL;

                $connect->createCommand()->insert('car_model', [
                    'name'        => $itemModel['name'],
                    'car_firm_id' => $firmId,
                    'date_create' => $date
                ])->execute();
                $modelId = $connect->getLastInsertID();

                if (empty($itemModel['has_children'])) {
                    continue;
                }

                $urlBodies = 'http://baza.drom.ru/ajax-control/modelSelectControl/mselect?mode=bodies&firm='
                    . $itemFirm['name'] . '&model=' . $itemModel['name'];
                $carBodies = mb_convert_encoding($curl->get($urlBodies), 'UTF-8', 'CP1251');
                if (empty($carBodies)) {
                    continue;
                }

                try {
                    $dataBodies = @json_decode($carBodies, true);
                } catch (Exception $e) {
                    continue;
                }

                $resultBodies = ArrayHelper::getValue($dataBodies, 'response.items', []);

                foreach ($resultBodies as $bodyK => $itemBody) {
                    $connect->createCommand()->insert('car_body', [
                        'name'         => $itemBody['name'],
                        'car_firm_id'  => $firmId,
                        'car_model_id' => $modelId,
                        'date_create'  => $date
                    ])->execute();
                    $bodyId = $connect->getLastInsertID();

                    if (empty($itemBody['has_children'])) {
                        continue;
                    }

                    $urlMotor = 'http://baza.drom.ru/ajax-control/modelSelectControl/mselect?mode=engines&firm='
                        . $itemFirm['name'] . '&model=' . $itemModel['name'] . '&bodyNumbers=&bodyNumbers='
                        . $itemBody['name'];
                    $carMotors = mb_convert_encoding($curl->get($urlMotor), 'UTF-8', 'CP1251');
                    if (empty($carMotors)) {
                        continue;
                    }

                    try {
                        $dataMotors = @json_decode($carMotors, true);
                    } catch (Exception $e) {
                        continue;
                    }

                    $resultMotors = ArrayHelper::getValue($dataMotors, 'response.items', []);

                    foreach ($resultMotors as $itemMotor) {
                        $connect->createCommand()->insert('car_motor', [
                            'name'         => $itemMotor['name'],
                            'car_firm_id'  => $firmId,
                            'car_model_id' => $modelId,
                            'car_body_id'  => $bodyId,
                            'date_create'  => $date
                        ])->execute();
                    }
                }
            }
        }
    }
}
