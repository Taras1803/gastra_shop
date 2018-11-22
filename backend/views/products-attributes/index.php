<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductsAttributesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products Attributes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-success" style="padding: 10px;">
    <div class="box-body">
        <div class="page-content-index">

            <p class="pull-right">
                <?= Html::a('Добавить атрибут', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'slug',
                    'ru',
                    'uk',

                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view}&nbsp;&nbsp;{update}',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
