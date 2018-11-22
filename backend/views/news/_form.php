<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">
    <!--    <div class="row" style="text-align: center;">-->
    <!--        <a href="#" id="js__addProductImg">Добавить Изображение</a>-->
    <!--    </div>-->
    <div class="clearfix"></div>
    <br>
    <div class="row imgContainer">
        <?php $images = explode("|", $model->images) ?>
        <div class="col-md-4 col-lg-4 col-sm-4">
            <a href="#" class="js__clearImage">X</a>
            <div class="dropZone">
                <div class="imageBlock">
                    <?php if (isset($images[0])): ?>
                        <img class="newImage" src="<?= Yii::$app->glide->createSignedUrl([
                            'glide/index',
                            'path' => 'blog/' . $images[0],
                            'w' => 135
                        ], true) ?>" data-img="<?= $images[0] ?>"
                             style="display: inline-block; max-width: 100%; vertical-align: middle; max-height: 140px;">
                    <?php else: ?>
                        Выбрать
                    <?php endif; ?>
                </div>
                <input type="file" accept="image/png,image/jpeg" data-path="temp/" data-target="#news-images"
                       data-action="multi-image">
            </div>
        </div>

        <div class="col-md-4 col-lg-4 col-sm-4">
            <a href="#" class="js__clearImage">X</a>
            <div class="dropZone">
                <div class="imageBlock">
                    <?php if (isset($images[1])): ?>
                        <img class="newImage" src="<?= Yii::$app->glide->createSignedUrl([
                            'glide/index',
                            'path' => 'blog/' . $images[1],
                            'w' => 135
                        ], true) ?>" data-img="<?= $images[1] ?>"
                             style="display: inline-block; max-width: 100%; vertical-align: middle; max-height: 140px;">
                    <?php else: ?>
                        Выбрать
                    <?php endif; ?>
                </div>
                <input type="file" accept="image/png,image/jpeg" data-path="temp/" data-target="#news-images"
                       data-action="multi-image">
            </div>
        </div>
    </div>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'images')->hiddenInput(['maxlength' => true])->label(false) ?>

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
                    <?= $form->field($descriptions[$item->id], 'title')->textInput(['maxlength' => true, 'id' => 'NewsDescriptions' . $item->id . '-title', 'name' => 'NewsDescriptions' . $item->id . '[title]']) ?>

                    <?= $form->field($descriptions[$item->id], 'short_description')->textarea(['rows' => 4, 'id' => 'NewsDescriptions' . $item->id . '-short_description', 'name' => 'NewsDescriptions' . $item->id . '[short_description]']) ?>

                    <?= $form->field($descriptions[$item->id], 'description')->widget(CKEditor::class, [
                        'options' => [
                            'id' => 'NewsDescriptions' . $item->id . '-description',
                            'name' => 'NewsDescriptions' . $item->id . '[description]'
                        ],
                        'editorOptions' => [
                            'preset' => 'full',
                            'filebrowserBrowseUrl' => '/manager/elfinder/manager',
                            'clientOptions' => ElFinder::ckeditorOptions('elfinder', []),
                            'customConfig' => '/manager/js/config.js',
                        ]
                    ]); ?>

                    <?= $form->field($descriptions[$item->id], 'meta_title')->textInput(['maxlength' => true, 'id' => 'NewsDescriptions' . $item->id . '-meta_title', 'name' => 'NewsDescriptions' . $item->id . '[meta_title]']) ?>

                    <?= $form->field($descriptions[$item->id], 'meta_description')->textarea(['rows' => 2, 'id' => 'NewsDescriptions' . $item->id . '-meta_description', 'name' => 'NewsDescriptions' . $item->id . '[meta_description]']) ?>

                    <?= $form->field($descriptions[$item->id], 'meta_keywords')->textInput(['maxlength' => true, 'id' => 'NewsDescriptions' . $item->id . '-meta_keywords', 'name' => 'NewsDescriptions' . $item->id . '[meta_keywords]']) ?>
                </div>
                <!-- /.tab-pane -->
            <?php endforeach; ?>
        </div>
    </div>

    <a href="#" class="generate-slug" data-name="#NewsDescriptions1-title" data-target="#news-slug"
       title="Сгенерировать slug" data-error="Заполните Заголовок"
       style="float: right; top: -1px; position: relative; font-size: 20px;">
        <i class="fa fa-fw fa-plus-circle"></i>
    </a>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList($model::getStatus()) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
