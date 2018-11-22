<?php

use common\models\PromoCodes;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PromoCodesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Промокоды';
$this->params['breadcrumbs'][] = $this->title;
$userTime = \common\models\CurrentTime::getUserOffsetTime();
$types = PromoCodes::getTypes();
$status = PromoCodes::getStatus();
?>
<div class="box box-success" style="padding: 10px;">
    <div class="box-body">
        <div class="promo-codes-index">

            <p class="pull-right">
                <?= Html::a('Добавить промокод', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    [
                        'attribute' => 'promo_code',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel->promo_code;
                        }
                    ],
                    [
                        'attribute' => 'type',
                        'format' => 'raw',
                        'value' => function ($searchModel) use ($types) {
                            return $types[$searchModel->type];
                        },
                        'filter' => Html::activeDropDownList($searchModel, 'type', $types, ['class' => 'form-control', 'prompt' => 'Тип'])
                    ],
                    [
                        'attribute' => 'value',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel->value;
                        }
                    ],
                    [
                        'attribute' => 'start_date',
                        'format' => 'raw',
                        'value' => function ($searchModel) use ($userTime) {
                            if ($searchModel->start_date) {
                                return date("d.m.Y", $searchModel->start_date + $userTime);
                            } else {
                                return "Не назначена";
                            }
                        },
                    ],

                    [
                        'attribute' => 'finish_date',
                        'format' => 'raw',
                        'value' => function ($searchModel) use ($userTime) {
                            if ($searchModel->finish_date) {
                                return date("d.m.Y", $searchModel->finish_date + $userTime);
                            } else {
                                return "Не назначена";
                            }
                        },
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($searchModel) use ($status) {
                            return $status[$searchModel->status];
                        },
                        'filter' => Html::activeDropDownList($searchModel, 'status', $status, ['class' => 'form-control', 'prompt' => 'Статус'])
                    ],


                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>

<style>
    #w0 .table-bordered tr th:first-child {
        display: none;
    }

    #w0 .table-bordered tr td:first-child {
        display: none;
    }
</style>