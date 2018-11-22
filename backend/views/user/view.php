<?php

use common\models\CurrentTime;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */

$this->title = 'Пользователь №' .$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$userTime = CurrentTime::getUserOffsetTime();
?>
<div class="box box-success" style="padding: 10px;">
    <div class="box-body">
        <div class="col-lg-8 col-lg-offset-2">

            <p class="pull-right">
                <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'last_name',
                    'first_name',
                    'middle_name',
                    'dob',
                    'organization',
                    'city',
                    'address',
                    [
                        'attribute' => 'lang',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel::getLangs()[$searchModel->lang];
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel::getStatus()[$searchModel->status];
                        }
                    ],
                    'discount_card',
                    'discount',
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

                ],
            ]) ?>

        </div>
    </div>
</div>
