<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\OrdersStatus */

$this->title = $model->ru;
$this->params['breadcrumbs'][] = ['label' => 'Статусы Заказов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-success" style="padding: 10px;">
    <div class="box-body">
        <div class="col-lg-4 col-lg-offset-4">

            <p class="pull-right">
                <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'ru',
                    'uk',
                    'en',
                    [
                        'attribute' => 'color',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return '<span class="colorStatus" style="background: ' . $searchModel->color . ';">Цвет</span>';
                        }
                    ],
                ],
            ]) ?>

        </div>
    </div>
</div>
