<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Categories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categories-form">
    <div class="row imgContainer">
        <?php $images = explode("|", $model->image) ?>
        <?php foreach($images as $img): ?>
            <div class="col-md-4 col-lg-4 col-sm-4">
                <!--                <a href="#" class="js__removeImg">X</a>-->
                <div class="dropZone">
                    <div class="imageBlock">
                        <?php if ($img): ?>
                            <img class="newImage" src="<?= Yii::$app->glide->createSignedUrl([
                                'glide/index',
                                'path' => 'categories/' . $img,
                                'w' => 135
                            ], true) ?>" data-img="<?= $img ?>"
                                 style="display: inline-block; max-width: 100%; vertical-align: middle; max-height: 140px;">
                        <?php else: ?>
                            Выбрать
                        <?php endif; ?>
                    </div>
                    <input type="file" accept="image/png,image/jpeg" data-path="temp/" data-target="#categories-image" data-action="multi-image">
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'image')->hiddenInput(['maxlength' => true])->label(false) ?>

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
                    <?= $form->field($descriptions[$item->id], 'name')->textInput(['maxlength' => true, 'id' => 'CategoriesDescriptions' . $item->id . '-name', 'name' => 'CategoriesDescriptions' . $item->id . '[name]']) ?>
                    <?= $form->field($descriptions[$item->id], 'description')->textarea(['rows' => 4, 'id' => 'CategoriesDescriptions' . $item->id . '-description', 'name' => 'CategoriesDescriptions' . $item->id . '[description]']) ?>
                    <?= $form->field($descriptions[$item->id], 'meta_title')->textInput(['maxlength' => true, 'id' => 'CategoriesDescriptions' . $item->id . '-meta_title', 'name' => 'CategoriesDescriptions' . $item->id . '[meta_title]']) ?>

                    <?= $form->field($descriptions[$item->id], 'meta_description')->textarea(['rows' => 2, 'id' => 'CategoriesDescriptions' . $item->id . '-meta_description', 'name' => 'CategoriesDescriptions' . $item->id . '[meta_description]']) ?>

                    <?= $form->field($descriptions[$item->id], 'meta_keywords')->textInput(['maxlength' => true, 'id' => 'CategoriesDescriptions' . $item->id . '-meta_keywords', 'name' => 'CategoriesDescriptions' . $item->id . '[meta_keywords]']) ?>
                </div>
                <!-- /.tab-pane -->
            <?php endforeach; ?>
        </div>
    </div>

    <a href="#" class="generate-slug" data-name="#CategoriesDescriptions2-name" data-target="#categories-slug"
       title="Сгенерировать slug"
       style="float: right; top: -1px; position: relative; font-size: 20px;">
        <i class="fa fa-fw fa-plus-circle"></i>
    </a>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent')->dropDownList($parents) ?>

    <?= $form->field($model, 'sort')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'status')->dropDownList($model::getStatus()) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
