<?php
/** @var \common\models\requestOffer\RequestOffer $model */

use yii\helpers\Html;
use common\models\company\CompanyContactData;
use common\models\company\CompanyTypeDelivery;
use yii\helpers\ArrayHelper;
use frontend\modules\dashboard\forms\RequestOfferForm;

$offerAttributeLabels = (new RequestOfferForm())->attributeLabels();
?>

<div class="<?= $cssClass; ?> requestOfferBlock" data-counter="<?= $counter; ?>">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <h5 class="titleF15">Цена</h5>
        <h3 class="price"><?= $model->price; ?> руб.</h3>

        <h3 class="companyName"><?= $model->company->actual_name; ?></h3>
        
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php if (!empty($model->company->companyAddresses)) : ?>
                    <?php
                    $firstAddress = $model->company->companyAddresses[0];
                    $timeWork = $firstAddress->getTimeWorkDataAsString();

                    $typeDeliveries = [];
                    foreach ($model->company->companyTypeDeliveries as $typeDelivery) {
                        $typeDeliveries[] = CompanyTypeDelivery::$typeList[$typeDelivery->type];
                    }

                    echo Html::hiddenInput('addressCoordinates', $firstAddress->map_coordinates,
                        ['class' => 'addressCoordinates']);
                    ?>

                    <div class="address"><?= $firstAddress->address; ?></div>
                    <a class="collapseBtn small collapsed" type="button" data-toggle="collapse" data-target="#allCompanyPhone<?= $counter; ?>" aria-expanded="false" aria-controls="allCompanyPhone">
                        <span class="rollUp">Посмотреть все контакты</span>
                        <span class="chevron"></span>
                    </a>
                    <div class="collapseBox">
                        <div class="collapse" id="allCompanyPhone<?= $counter; ?>">
                            <?php foreach ($firstAddress->companyContactDatas as $contact) : ?>
                                <div class="companyPhone">
                                    <div class="svg">
                                        <svg width="14" height="14" viewBox="0 0 14 14">
                                            <path d="M2.800,6.067 C3.889,8.244 5.755,10.033 7.933,11.200 L9.644,9.489 C9.878,9.255 10.189,9.178 10.422,9.333 C11.278,9.644 12.211,9.800 13.222,9.800 C13.689,9.800 14.000,10.111 14.000,10.578 L14.000,13.222 C14.000,13.689 13.689,14.000 13.222,14.000 C5.911,14.000 -0.000,8.089 -0.000,0.778 C-0.000,0.311 0.311,-0.000 0.778,-0.000 L3.500,-0.000 C3.966,-0.000 4.278,0.311 4.278,0.778 C4.278,1.711 4.433,2.644 4.744,3.578 C4.822,3.811 4.744,4.122 4.589,4.355 L2.800,6.067 Z"/>
                                        </svg>
                                    </div>
                                    <span><?= $contact->data; ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                    <ul class="list-unstyled">
                        <li>
                            <a href="javascript:;" class="companyPhone showHidePhone">
                                <div class="svg">
                                    <svg width="14" height="14" viewBox="0 0 14 14">
                                        <path d="M2.800,6.067 C3.889,8.244 5.755,10.033 7.933,11.200 L9.644,9.489 C9.878,9.255 10.189,9.178 10.422,9.333 C11.278,9.644 12.211,9.800 13.222,9.800 C13.689,9.800 14.000,10.111 14.000,10.578 L14.000,13.222 C14.000,13.689 13.689,14.000 13.222,14.000 C5.911,14.000 -0.000,8.089 -0.000,0.778 C-0.000,0.311 0.311,-0.000 0.778,-0.000 L3.500,-0.000 C3.966,-0.000 4.278,0.311 4.278,0.778 C4.278,1.711 4.433,2.644 4.744,3.578 C4.822,3.811 4.744,4.122 4.589,4.355 L2.800,6.067 Z"/>
                                    </svg>
                                </div>
                                <span class="showPhoneText">Показать телефон</span>
                                <span class="showPhone">+7 (999) 999-9999</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" class="companyDeliveries">
                                <div class="svg">
                                    <svg width="16" height="7" viewBox="0 0 16 7">
                                      <path d="M15.131,5.657 C15.024,5.657 14.792,5.663 14.465,5.670 C14.431,4.862 13.717,4.214 12.842,4.214 C11.945,4.214 11.215,4.894 11.215,5.730 C11.215,5.736 11.216,5.742 11.216,5.749 C9.268,5.790 6.902,5.827 4.821,5.810 C4.822,5.783 4.825,5.757 4.825,5.730 C4.825,4.894 4.095,4.214 3.198,4.214 C2.308,4.214 1.583,4.885 1.573,5.713 C1.324,5.697 1.093,5.678 0.887,5.657 C0.887,5.657 -0.402,5.782 0.131,5.015 C0.131,5.015 0.020,1.286 0.909,0.416 C1.798,-0.454 10.842,0.292 10.842,0.292 C10.842,0.292 13.642,1.569 14.642,2.505 C15.642,3.441 15.776,2.861 15.776,4.186 C15.776,4.186 15.998,4.062 15.998,4.870 C15.998,5.678 16.042,5.657 15.131,5.657 ZM3.198,4.462 C3.949,4.462 4.558,5.030 4.558,5.730 C4.558,5.756 4.552,5.781 4.550,5.807 C4.507,6.471 3.921,6.997 3.199,6.997 C2.448,6.997 1.839,6.430 1.839,5.730 C1.839,5.729 1.839,5.729 1.839,5.729 C1.840,5.029 2.448,4.462 3.198,4.462 ZM12.841,4.462 C13.573,4.462 14.165,5.002 14.195,5.677 C14.196,5.695 14.201,5.712 14.201,5.730 C14.201,6.430 13.592,6.998 12.841,6.998 C12.095,6.998 11.491,6.437 11.483,5.743 C11.483,5.739 11.482,5.734 11.482,5.730 C11.482,5.030 12.091,4.462 12.841,4.462 Z"/>
                                    </svg>
                                </div>
                                <span>Доставка по городу</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" class="companyDeliveries">
                                <div class="svg">
                                    <svg width="18" height="9" viewBox="0 0 18 9">
                                      <path d="M11.781,0.443 L12.240,5.326 L12.240,0.340 C12.240,0.152 12.401,-0.000 12.600,-0.000 L16.500,-0.000 C16.663,-0.000 16.805,0.103 16.847,0.251 L17.988,4.217 C17.996,4.246 18.000,4.276 18.000,4.306 L18.000,7.026 C18.000,7.214 17.839,7.366 17.640,7.366 L16.564,7.366 C16.574,7.431 16.579,7.497 16.579,7.565 C16.579,8.356 15.898,9.000 15.060,9.000 C14.222,9.000 13.541,8.356 13.541,7.565 C13.541,7.497 13.546,7.431 13.556,7.366 L7.442,7.366 C7.451,7.431 7.457,7.497 7.457,7.565 C7.457,8.356 6.775,9.000 5.937,9.000 C5.099,9.000 4.418,8.356 4.418,7.565 C4.418,7.497 4.423,7.431 4.433,7.366 L3.982,7.366 C3.992,7.431 3.997,7.497 3.997,7.565 C3.997,8.356 3.315,9.000 2.478,9.000 C1.640,9.000 0.958,8.356 0.958,7.565 C0.958,7.497 0.964,7.431 0.973,7.366 L0.360,7.366 C0.161,7.366 -0.000,7.214 -0.000,7.026 L-0.000,5.666 C-0.000,5.478 0.161,5.326 0.360,5.326 L0.553,0.414 M16.225,0.680 L14.880,0.680 L14.880,3.407 L17.138,3.858 L16.225,0.680 ZM15.060,8.320 C15.501,8.320 15.859,7.981 15.859,7.565 C15.859,7.149 15.501,6.810 15.060,6.810 C14.619,6.810 14.261,7.149 14.261,7.565 C14.261,7.981 14.619,8.320 15.060,8.320 ZM15.060,6.130 C15.547,6.130 15.981,6.348 16.260,6.686 L13.861,6.686 C14.139,6.348 14.573,6.130 15.060,6.130 ZM5.937,8.320 C6.378,8.320 6.736,7.981 6.736,7.565 C6.736,7.149 6.378,6.810 5.937,6.810 C5.496,6.810 5.138,7.149 5.138,7.565 C5.138,7.981 5.496,8.320 5.937,8.320 ZM2.478,8.320 C2.918,8.320 3.277,7.981 3.277,7.565 C3.277,7.149 2.918,6.810 2.478,6.810 C2.037,6.810 1.678,7.149 1.678,7.565 C1.678,7.981 2.037,8.320 2.478,8.320 ZM0.720,6.686 L1.278,6.686 C1.556,6.348 1.990,6.130 2.478,6.130 C2.965,6.130 3.399,6.348 3.677,6.686 L4.738,6.686 C5.016,6.348 5.450,6.130 5.937,6.130 C6.424,6.130 6.859,6.348 7.137,6.686 L12.240,6.686 L0.720,6.686 Z"/>
                                    </svg>
                                </div>
                                <span>Доставка межгород</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" class="companyDeliveries">
                                <div class="svg">
                                    <svg width="9" height="13" viewBox="0 0 9 13">
                                      <path d="M4.500,-0.000 C1.993,-0.000 -0.000,2.015 -0.000,4.550 C-0.000,7.930 4.500,13.000 4.500,13.000 C4.500,13.000 9.000,7.930 9.000,4.550 C9.000,2.015 7.007,-0.000 4.500,-0.000 ZM4.500,6.175 C3.600,6.175 2.893,5.460 2.893,4.550 C2.893,3.640 3.600,2.925 4.500,2.925 C5.400,2.925 6.107,3.640 6.107,4.550 C6.107,5.460 5.400,6.175 4.500,6.175 Z"/>
                                    </svg>
                                </div>
                                <span>Самовывоз</span>
                            </a>
                        </li>
                    </ul>
                    
                    <?//= implode(', ', $typeDeliveries); ?>
                    
                    <?php if (!empty($timeWork)) : ?>
                        <h6 class="timeWorkText">Время работы:</h6>

                        <a class="collapseBtn collapsed" type="button" data-toggle="collapse" data-target="#allTimeWork<?= $counter; ?>" aria-expanded="false" aria-controls="allCompanyPhone">
                            <h5 class="timeWork">Сегодня с 10:00 до 20:00</h5>
                            <span class="chevron"></span>
                        </a>
                        <div class="collapseBox">
                            <div class="collapse" id="allTimeWork<?= $counter; ?>">
                                <?//= $timeWork; ?>
                                <div class="schedule_dropdown">
                                    <table class="schedule_table">
                                        <tbody>
                                            <tr class="schedule_tr keys">
                                                <th class="schedule_th">пн</th>
                                                <th class="schedule_th dayoff">вт</th>
                                                <th class="schedule_th dayoff">ср</th>
                                                <th class="schedule_th active">чт</th>
                                                <th class="schedule_th dayoff">пт</th>
                                                <th class="schedule_th dayoff">сб</th>
                                                <th class="schedule_th dayoff">вс</th>
                                            </tr>
                                            <tr class="schedule_tr work">
                                                <td class="schedule_td">
                                                    <time class="schedule_tableTime">19:00</time>
                                                    <time class="schedule_tableTime">21:00</time>
                                                </td>
                                                <td class="schedule_td dayoff">
                                                    <span class="schedule_dayoff fa fa-close"></span>
                                                </td>
                                                <td class="schedule_td dayoff">
                                                    <span class="schedule_dayoff fa fa-close"></span>
                                                </td>
                                                <td class="schedule_td active">
                                                    <time class="schedule_tableTime">09:30</time>
                                                    <time class="schedule_tableTime">11:30</time>
                                                </td>
                                                <td class="schedule_td dayoff">
                                                    <span class="schedule_dayoff fa fa-close"></span>
                                                </td>
                                                <td class="schedule_td dayoff">
                                                    <span class="schedule_dayoff fa fa-close"></span>
                                                </td>
                                                <td class="schedule_td dayoff">
                                                    <span class="schedule_dayoff fa fa-close"></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        
                    <?php endif; ?>

                <?php endif; ?>
                
                <div class="dotItemBox">
                    <div class="dotItem date">
                        <div class="diLabel">Дата создания</div>
                        <div class="diValue">30.04.2016</div>
                    </div>
                </div>
            
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php $deliveryDays = []; ?>
                <div class="dotItemBox">
                    <?php foreach ($model->getAttributesData() as $attribute => $value) : ?>
                        <?php
                        if ($attribute == 'deliveryDayFrom' || $attribute == 'deliveryDayTo') {
                            $deliveryDays[$attribute] = $value;
                            continue;
                        }
                        ?>
                        <div class="dotItem small">
                            <div class="diLabel"><?= ArrayHelper::getValue($offerAttributeLabels, $attribute); ?></div>
                            <div class="diValue"><?= $value; ?></div>
                        </div>
                    <?php endforeach; ?>
                    
                    <?php if (!empty($deliveryDays)) : ?>
                        <div class="dotItem small">
                            <div class="diLabel">Срок доставки</div>
                            <div class="diValue">
                                <?= ArrayHelper::getValue($deliveryDays, 'deliveryDayFrom'); ?> -
                                <?= ArrayHelper::getValue($deliveryDays, 'deliveryDayTo'); ?> дн.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                
                <div class="dotItem desc">
                    <div class="diLabel">Описание</div>
                    <div class="diValue"><?= $model->description; ?></div>
                </div>
                <?php if (!empty($model->comment)) : ?>
                    <div class="dotItem desc">
                        <div class="diLabel">Комментарий</div>
                        <div class="diValue"><?= $model->comment; ?></div>
                    </div>
                <?php endif; ?>

                <div class="clearfix"></div>
                <?php if (!empty($model->requestOfferImages)) : ?>
                    <br>
                    <h5 class="titleF15">Изображения</h5>
                    <div class="imagesPreview">
                        <?php foreach ($model->requestOfferImages as $image) : ?>
                            <a class="fancybox imageBlock" rel="gallery_<?= $model->id; ?>"
                               href="<?= '/' . $image->name; ?>">
                                <img src="<?= '/' . $image->thumb_name; ?>" alt="gallery" class="img-responsive thumbnail" />
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <div class="clearfix"></div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">

                <a href="javascript:;" class="btn btn-default svgBtn sendMessageFromRequest" data-offer="<?= $model->id; ?>">
                    <div class="svg">
                        <svg width="21" height="21" viewBox="0 0 21 21">
                          <path d="M19.950,4.200 L17.850,4.200 L17.850,13.650 L4.200,13.650 L4.200,15.750 C4.200,16.380 4.620,16.800 5.250,16.800 L16.800,16.800 L21.000,21.000 L21.000,5.250 C21.000,4.620 20.580,4.200 19.950,4.200 ZM15.750,10.500 L15.750,1.050 C15.750,0.420 15.330,-0.000 14.700,-0.000 L1.050,-0.000 C0.420,-0.000 -0.000,0.420 -0.000,1.050 L-0.000,15.750 L4.200,11.550 L14.700,11.550 C15.330,11.550 15.750,11.130 15.750,10.500 Z"/>
                        </svg>
                    </div>
                    Связаться с компанией
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-xs-12">
        <h5 class="titleF15">На карте</h5>
        <div id="yandexMapCompany_<?= $counter; ?>" class="yandexMapCompany"></div>
    </div>
</div>