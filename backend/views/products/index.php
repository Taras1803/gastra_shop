<?php

use common\models\Products;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
$status = Products::getStatus();
$types = Products::getTypes();
?>
<div class="box box-success" style="padding: 10px;">
    <div class="box-body">
        <div class="page-content-index">

            <p class="pull-right">
                <?= Html::a('Добавить товар', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'id',
                    [
                        'attribute' => 'images',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            $images= explode("|", $searchModel->images);
                            return '<img src="' . Yii::$app->glide->createSignedUrl([
                                    'glide/index',
                                    'path' => 'products/' . $images[0],
                                    'w' => 120
                                ], true) . '" alt="image" style="max-width: 120px; max-height: 120px;" />';
                        }
                    ],
                    [
                        'attribute' => 'slug',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return vsprintf('<a href="/product/%s" target="_blank">%s</a>', [$searchModel->slug, $searchModel->slug]);
                        }
                    ],
                    [
                        'attribute' => 'price',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel->price;
                        }
                    ],
                    [
                        'attribute' => 'action',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel->action . '%';
                        }
                    ],
                    [
                        'attribute' => 'article',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel->article;
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($searchModel) use ($status) {
                            return $status[$searchModel->status];
                        },
                        'filter' => Html::activeDropDownList($searchModel, 'status', $status,['class'=>'form-control','prompt' => 'Статус'])
                    ],
                    [
                        'attribute' => 'type',
                        'format' => 'raw',
                        'value' => function ($searchModel) use($types) {
                            return $types[$searchModel->type];
                        },
                        'filter' => Html::activeDropDownList($searchModel, 'type', $types,['class'=>'form-control','prompt' => 'Тип'])
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