<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'Менеджеры';
?>

<div class="row">
    <div class="col-lg-6">
        <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
                <?php if (isset($model->username)): ?>
                    <h3 class="widget-user-username"><?= $model->username ?></h3>
                <?php endif; ?>
                <?php if (isset($model->role) && isset($roles[$model->role])): ?>
                    <h5 class="widget-user-desc"><?= $roles[$model->role] ?></h5>
                <?php endif; ?>
            </div>
            <div class="widget-user-image">
                <img class="img-circle" src="/manager/uploads/avatar/<?= $model->avatar ?>" alt="User Avatar">
            </div>
            <br>
            <br>
            <?php $form = ActiveForm::begin([
                'id' => 'update-profile-form',
                'method' => 'post'
            ]); ?>
            <div class="box-header">
                <?php if ($model->id == 0): ?>
                    <h3 class="box-title">Добавить менеджера</h3>
                <?php else: ?>
                    <h3 class="box-title">Обновить менеджера</h3>
                <?php endif; ?>
            </div>
            <div class="box-body">
                <!-- Username input -->
                <?= $form->field($model, 'username', [
                    'template' => "<label>ФИО*</label><div class=\"input-group\"><span class=\"input-group-addon\"><i class=\"fa  fa-user\"></i></span>{input}</div>{error}",
                ])->textInput(['placeholder' => 'ФИО']) ?>

                <!-- Login input -->
                <?= $form->field($model, 'phone', [
                    'template' => "<label>Телефон*</label><div class=\"input-group\"><span class=\"input-group-addon\"><i class=\"fa  fa-phone-square\"></i></span>{input}</div>{error}",
                ])->textInput(['placeholder' => 'Телефон']) ?>

                <!-- Email input -->
                <?= $form->field($model, 'email', [
                    'template' => "<label>Email*</label><div class=\"input-group\"><span class=\"input-group-addon\"><i class=\"fa  fa-envelope\"></i></span>{input}</div>{error}",
                ])->textInput(['placeholder' => 'Email']) ?>

                <!-- Password input -->
                <?= $form->field($model, 'password', [
                    'template' => "<label>Пароль*</label><div class=\"input-group\"><span class=\"input-group-addon\"><i class=\"fa  fa-lock\"></i></span>{input}</div>{error}",
                ])->textInput(['placeholder' => 'Пароль']) ?>

                <!-- Password input -->
                <?= $form->field($model, 'role')->dropDownList($roles) ?>


                <button type="submit" style="width: 30%" class="btn btn-info pull-right">Сохранить</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="col-lg-6">
        <p class="pull-right">
            <a class="btn btn-success" href="/manager/managers">Добавить</a>
        </p>
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th>#</th>
                <th>Имя</th>
                <th>Телефон</th>
                <th>Email</th>
                <th>Действие</th>
            </tr>
            </tbody>
            <?php if ($managers): ?>
                <?php foreach ($managers as $key => $item): ?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= $item->username ?></td>
                        <td><?= $item->phone ?></td>
                        <td><?= $item->email ?></td>
                        <td>
                            <a href="/manager/managers?id=<?= $item->id ?>" title="Update" aria-label="Обновить">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                            &nbsp;&nbsp;
                            <a href="#" class="deleteManager" data-id="<?= $item->id ?>" title="Удалить">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
</div>
<div class="clearfix"></div>