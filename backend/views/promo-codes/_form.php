<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PromoCodes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="promo-codes-form">
    <div class="clearfix"></div>
    <br>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'promo_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList($model::getTypes()) ?>

    <?= $form->field($model, 'value')->textInput() ?>

    <div class="dateform" >
        <?= $form->field($model, 'start_date')->widget(DatePicker::class, [
            'language' => 'ru',
            'dateFormat' => 'dd-MM-yyyy',
        ]) ?>
        <?= $form->field($model, 'finish_date')->widget(DatePicker::class, [
            'language' => 'ru',
            'dateFormat' => 'dd-MM-yyyy',
        ]) ?>
    </div>

    <?= $form->field($model, 'status')->dropDownList($model::getStatus()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<style>
    .dateform input{
        width: 100%;
    }
</style>
<script>
    $('input').attr('autocomplete','off');
</script>
