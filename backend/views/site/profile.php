<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'Профиль';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row col-lg-6 col-lg-offset-3">
    <div class="box box-widget widget-user">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-aqua-active">
            <h3 class="widget-user-username"><?= $user->username ?></h3>
            <h5 class="widget-user-desc"><?= $roles[$user->role] ?></h5>
        </div>
        <div id="changeAvatar" class="personalEdit__avatar"
             style="background-image: url(<?= "/manager/uploads/avatar/" . $user->avatar ?>);" data-img="<?= $user->avatar ?>">
            <label for="avatarInput">
                <img src="/manager/img/photo.png" alt="photo">
            </label>
            <input type="file" id="avatarInput" class="imageUploader" data-action="avatar" data-target="#updateprofileform-avatar" data-path="/avatar/" accept="image/*">
        </div>
        <br>
        <br>
        <?php $form = ActiveForm::begin([
            'id' => 'update-profile-form',
            'method' => 'post'
        ]); ?>
        <div class="box-header">
            <h3 class="box-title">Change your information</h3>
        </div>
        <div class="box-body">
            <?= $form->field($model, 'avatar')->hiddenInput()->label(false) ?>

            <!-- Username input -->
            <?= $form->field($model, 'username', [
                'template' => "<label>ФИО*</label><div class=\"input-group\"><span class=\"input-group-addon\"><i class=\"fa  fa-user\"></i></span>{input}</div>{error}",
            ])->textInput(['value' => $user->username, 'placeholder' => $model->getAttributeLabel('username')]) ?>

            <!-- Email input -->
            <?= $form->field($model, 'email', [
                'template' => "<label>Email*</label><div class=\"input-group\"><span class=\"input-group-addon\"><i class=\"fa  fa-envelope\"></i></span>{input}</div>{error}",
            ])->textInput(['value' => $user->email, 'placeholder' => $model->getAttributeLabel('email')]) ?>

            <!-- Email input -->
            <?= $form->field($model, 'phone', [
                'template' => "<label>Телефон*</label><div class=\"input-group\"><span class=\"input-group-addon\"><i class=\"fa  fa-phone-square\"></i></span>{input}</div>{error}",
            ])->textInput(['value' => $user->phone, 'placeholder' => $model->getAttributeLabel('phone')]) ?>


            <button type="submit" style="width: 30%" class="btn btn-info pull-right">Сохранить</button>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<div class="clearfix"></div>