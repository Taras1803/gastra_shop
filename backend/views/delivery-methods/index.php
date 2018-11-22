<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DeliveryMethodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Способы доставки';
$this->params['breadcrumbs'][] = $this->title;
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
                        'attribute' => 'title_ru',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel->title_ru;
                        }
                    ],
                    [
                        'attribute' => 'title_ru',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel->title_uk;
                        }
                    ],
                    [
                        'attribute' => 'title_ru',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel->title_en;
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
