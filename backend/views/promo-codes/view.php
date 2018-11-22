<?php

use common\models\CurrentTime;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PromoCodes */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Промокоды', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Промокод №' . $model->id;
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

            <div class="clearfix"></div>
            <hr>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'promo_code',
                    [
                        'attribute' => 'type',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel::getTypes()[$searchModel->type];
                        }
                    ],
                    'value',
                    [
                        'attribute' => 'start_date',
                        'format' => 'raw',
                        'value' => function ($searchModel) use ($userTime) {
                            if ($searchModel->start_date) {
                                return date("d.m.Y", $searchModel->start_date + $userTime);
                            } else {
                                return "Не назначена";
                            }
                        }
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
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel::getStatus()[$searchModel->status];
                        }
                    ],
                ],
            ]) ?>

        </div>
    </div>
</div>
