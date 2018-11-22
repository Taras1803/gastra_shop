<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
$userTime = \common\models\CurrentTime::getUserOffsetTime();
?>
<div class="box box-success" style="padding: 10px;">
    <div class="box-body">
        <div class="page-content-index">

            <p class="pull-right">
                <?= Html::a('Добавить новость', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'images',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            $images= explode("|", $searchModel->images);
                            return '<img src="' . Yii::$app->glide->createSignedUrl([
                                    'glide/index',
                                    'path' => 'blog/' . $images[0],
                                    'w' => 120
                                ], true) . '" alt="image" style="max-width: 120px; max-height: 120px;" />';
                        }
                    ],
                    [
                        'attribute' => 'id',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return vsprintf('<a href="/news/%s" target="_blank">%s</a>', [$searchModel->id, $searchModel->id]);
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel::getStatus()[$searchModel->status];
                        },
                        'filter' => Html::activeDropDownList($searchModel, 'status', \common\models\News::getStatus(),['class'=>'form-control','prompt' => 'Статус'])
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'raw',
                        'value' => function ($searchModel) use ($userTime) {
                            return date("H:i d.m.Y", $searchModel->created_at + $userTime);
                        }
                    ],
                    [
                        'attribute' => 'updated_at',
                        'format' => 'raw',
                        'value' => function ($searchModel) use ($userTime) {
                            return date("H:i d.m.Y", $searchModel->updated_at + $userTime);
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
