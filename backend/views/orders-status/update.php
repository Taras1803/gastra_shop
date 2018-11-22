<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OrdersStatus */

$this->title = 'Обновить Статус: ' . $model->ru;
$this->params['breadcrumbs'][] = ['label' => 'Статусы Заказов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ru, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="box box-success" style="padding: 10px;">
    <div class="box-body">
        <div class="col-lg-4 col-lg-offset-4">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
