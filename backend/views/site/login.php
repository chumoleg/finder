<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model common\forms\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<p>Please fill out the following fields to login:</p>

<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'rememberMe')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
