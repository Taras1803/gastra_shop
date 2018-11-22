<?php

use common\models\CurrentTime;
use common\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
$userTime = CurrentTime::getUserOffsetTime();
?>
<div class="box box-success" style="padding: 10px;">
    <div class="box-body">
        <div class="page-content-index">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'id',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel->id;
                        }
                    ],
                    [
                        'attribute' => 'email',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel->email;
                        },
                    ],
                    [
                        'attribute' => 'first_name',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel->first_name;
                        }
                    ],
                    [
                        'attribute' => 'last_name',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel->last_name;
                        }
                    ],
                    [
                        'attribute' => 'discount',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel->discount;
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel::getStatus()[$searchModel->status];
                        },
                        'filter' => User::getStatus()
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'raw',
                        'value' => function ($searchModel) use ($userTime) {
                            return date("H:i d.m.Y", $searchModel->created_at + $userTime);
                        }
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update}&nbsp;{view}',
                    ],
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
