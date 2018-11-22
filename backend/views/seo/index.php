<?php

use common\models\CurrentTime;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SeoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Настройки SEO';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-success" style="padding: 10px;">
    <div class="box-body">
        <div class="page-content-index">
            <p class="pull-right">
                <?= Html::a('Добавить SEO', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'slug',
                    'description',
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update}&nbsp;{view}',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
