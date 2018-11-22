<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы клиентов';
$this->params['breadcrumbs'][] = $this->title;
$userTime = \common\models\CurrentTime::getUserOffsetTime();
?>
<div class="box box-success" style="padding: 10px;">
    <div class="box-body">
        <div class="brands-index">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Значение</th>
                        <th>Тип</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <input type="text" class="form-control item-data required" name="value" value="<?= $_GET['value'] ?>">
                        </td>
                        <td>
                            <select class="form-control item-data required" name="type">
                                <option value="title">По наименованию товара</option>
                            </select>
                        </td>
                        <td>
                            <a href="#" class="btn btn-primary js__getOrderBy">Поиск</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="clearfix"></div>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    [
                        'attribute' => 'user_name',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return ($searchModel->user_id > 0)? '<a href="/manager/user/view?id=' . $searchModel->user_id .'">' . $searchModel->user_name .'</a>' : $searchModel->user_name;
                        }
                    ],
                    [
                        'attribute' => 'total_price',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel->total_price . $searchModel->currency;
                        }
                    ],
                    'delivery_method',
                    'payment_method',
                    [
                        'attribute' => 'status_id',
                        'format' => 'raw',
                        'value' => function ($searchModel) use ($status) {
                            return '<span class="colorStatus" style="background: ' . $status[$searchModel->status_id]['color'] . ';">' . $status[$searchModel->status_id]['title'] . '</span>';
                        },
                        'filter' => Html::activeDropDownList($searchModel, 'status_id', $orderStatus,['class'=>'form-control','prompt' => 'Выберите статус'])
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'raw',
                        'value' => function ($searchModel) use ($userTime) {
                            return date("H:i d.m.Y", $searchModel->created_at + $userTime);
                        },
                        'filter' => Html::input('datetime-local', 'OrdersSearch[date]', ($_GET['OrdersSearch']['date'])? $_GET['OrdersSearch']['date'] : '' , ['class'=>'form-control', 'id' => 'timeFrom'])
                    ],

                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view}',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

<style>
    #w0 .table-bordered tr th:first-child{
        display: none;
    }
    #w0 .table-bordered tr td:first-child{
        display: none;
    }
</style>
