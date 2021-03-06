<?php

use common\components\Status;
use common\models\car\CarFirm;
use frontend\components\SearchFormGenerator;

/** @var $model frontend\forms\request\AutoPartForm */
/** @var $rubric common\models\rubric\Rubric */
/** @var $this \yii\web\View */

$form = SearchFormGenerator::getFormFiles($rubric->id);
?>

<?= $this->render('_parts/_partOrServiceRow', [
    'form'        => $form,
    'model'       => $model,
    'buttonText'  => 'Добавить еще одну запчасть',
    'placeholder' => 'Название запчасти',
]); ?>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
            <hr/>
            <?= $this->render('_parts/_carSelect', [
                'form'                 => $form,
                'model'                => $model,
                'carFirms'             => CarFirm::getListByImport(Status::STATUS_NOT_ACTIVE),
                'withoutBodyAndEngine' => true
            ]); ?>
        </div>
    </div>

<?= $this->render('_parts/_needleDelivery', ['form' => $form, 'model' => $model]); ?>
<?= $this->render('_parts/_additionOptionsButton'); ?>
<?= $this->render('_parts/_additionBlock', ['form' => $form, 'model' => $model]); ?>
<?= $this->render('_parts/_captcha', ['form' => $form, 'model' => $model]); ?>
<?= $this->render('_parts/_buttons'); ?>

<?php $form->end(); ?>