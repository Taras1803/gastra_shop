<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OrdersStatus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-status-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'ru')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uk')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color')->textInput(['type' => 'color', 'maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
