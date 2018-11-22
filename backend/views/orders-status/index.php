<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrdersStatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статусы заказов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-success" style="padding: 10px;">
    <div class="box-body">
        <div class="brands-index">

            <p class="pull-right">
                <?= Html::a('Добавить статус заказа', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

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

                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view}&nbsp;&nbsp;{update}',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

<style>
    .table-bordered tr th:first-child{
        display: none;
    }
    .table-bordered tr td:first-child{
        display: none;
    }
</style>
