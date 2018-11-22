<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Seo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if($model->isNewRecord): ?>
        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    <?php endif; ?>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <?php foreach ($langs as $key => $item): ?>
                <li class="<?= ($key == 0) ? 'active' : '' ?>">
                    <a href="#tab_<?= $key ?>" data-toggle="tab"><?= $item->name ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="tab-content">
            <?php foreach ($langs as $key => $item): ?>
            <div class="tab-pane <?= ($key == 0) ? 'active' : '' ?>" id="tab_<?= $key ?>">
                <?= $form->field($descriptions[$item->id], 'meta_title')->textInput(['maxlength' => true, 'id' => 'SeoDescription' . $item->id . '-meta_title', 'name' => 'SeoDescription' . $item->id . '[meta_title]']) ?>

                <?= $form->field($descriptions[$item->id], 'meta_description')->textarea(['rows' => 2, 'id' => 'SeoDescription' . $item->id . '-meta_description', 'name' => 'SeoDescription' . $item->id . '[meta_description]']) ?>

                <?= $form->field($descriptions[$item->id], 'meta_keywords')->textInput(['maxlength' => true, 'id' => 'SeoDescription' . $item->id . '-meta_keywords', 'name' => 'SeoDescription' . $item->id . '[meta_keywords]']) ?>
            </div>
                <!-- /.tab-pane -->
            <?php endforeach; ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
