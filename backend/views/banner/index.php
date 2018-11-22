<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Главный баннер';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-success" style="padding: 10px;">
    <div class="box-body">
        <div class="page-content-index">

            <p class="pull-right">
                <?= Html::a('Добавить баннер', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'image',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            $images= explode("|", $searchModel->image);
                            return '<img src="' . Yii::$app->glide->createSignedUrl([
                                    'glide/index',
                                    'path' => 'banners/' . $images[0],
                                    'w' => 120
                                ], true) . '" alt="image" style="max-width: 120px; max-height: 120px;" />';
                        }
                    ],

                    [
                        'attribute' => 'sort',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel->sort;
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel::getStatus()[$searchModel->status];
                        },
                        'filter' => Html::activeDropDownList($searchModel, 'status', \common\models\Banner::getStatus(),['class'=>'form-control','prompt' => 'Статус'])
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update}&nbsp;{view}',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
