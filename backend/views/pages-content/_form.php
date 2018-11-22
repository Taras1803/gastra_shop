<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model common\models\PagesContent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pages-content-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($model->isNewRecord): ?>
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
                    <?= $form->field($descriptions[$item->id], 'content')->widget(CKEditor::className(), [
                        'options' => [
                            'id' => 'PagesContentDescription' . $item->id . '-content',
                            'name' => 'PagesContentDescription' . $item->id . '[content]'
                        ],
                        'editorOptions' => [
                            'preset' => 'full',
                            'filebrowserBrowseUrl' => '/manager/elfinder/manager',
                            'clientOptions' => ElFinder::ckeditorOptions('elfinder', []),
                            'customConfig' => '/manager/js/config.js',
                        ]
                    ]); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
