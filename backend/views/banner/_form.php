<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model common\models\Banner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-form">
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
                                'path' => 'banners/' . $img,
                                'w' => 135
                            ], true) ?>" data-img="<?= $img ?>"
                                 style="display: inline-block; max-width: 100%; vertical-align: middle; max-height: 140px;">
                        <?php else: ?>
                            Выбрать
                        <?php endif; ?>
                    </div>
                    <input type="file" accept="image/png,image/jpeg" data-path="temp/" data-target="#banner-image" data-action="multi-image">
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
                    <?= $form->field($descriptions[$item->id], 'title')->textInput(['maxlength' => true, 'id' => 'BannerDescription' . $item->id . '-title', 'name' => 'BannerDescription' . $item->id . '[title]']) ?>
                    <?= $form->field($descriptions[$item->id], 'description')->widget(CKEditor::className(), [
                        'options' => [
                            'id' => 'BannerDescription' . $item->id . '-description',
                            'name' => 'BannerDescription' . $item->id . '[description]'
                        ],
                        'editorOptions' => [
                            'preset' => 'full',
                            'filebrowserBrowseUrl' => '/manager/elfinder/manager',
                            'clientOptions' => ElFinder::ckeditorOptions('elfinder', []),
                            'customConfig' => '/manager/js/config.js',
                        ]
                    ]); ?>

                    <?= $form->field($descriptions[$item->id], 'link_name')->textInput(['maxlength' => true, 'id' => 'BannerDescription' . $item->id . '-link_name', 'name' => 'BannerDescription' . $item->id . '[link_name]']) ?>

                    <?= $form->field($descriptions[$item->id], 'link')->textInput(['maxlength' => true, 'id' => 'BannerDescription' . $item->id . '-link', 'name' => 'BannerDescription' . $item->id . '[link]']) ?>

                </div>
                <!-- /.tab-pane -->
            <?php endforeach; ?>
        </div>
    </div>


    <?= $form->field($model, 'status')->dropDownList($model::getStatus()) ?>

    <?= $form->field($model, 'sort')->textInput(['type' => 'number']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
