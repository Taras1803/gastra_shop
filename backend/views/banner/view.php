<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Banner */

$this->title = 'Банер №' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Главный банер', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$userTime = \common\models\CurrentTime::getUserOffsetTime();
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
            <?php $images = explode("|", $model->image) ?>
            <div class="row">
                <h4 style="margin-left: 15px;">Изображения</h4>
                <?php foreach ($images as $img): ?>
                    <div class="col-sm-4">
                        <img style="max-width: 90%; max-height: 150px;" src="<?= Yii::$app->glide->createSignedUrl([
                            'glide/index',
                            'path' => 'banners/' . $img,
                            'w' => 200
                        ], true) ?>" alt="img">
                    </div>
                <?php endforeach; ?>
            </div>
            <hr>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel::getStatus()[$searchModel->status];
                        }
                    ],
                ],
            ]) ?>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <?php foreach ($langs as $key => $item): ?>
                        <li class="<?= ($key == 0) ? 'active' : '' ?>">
                            <a href="#tab_<?= $key ?>" data-toggle="tab"><?= $item->name ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="tab-content">
                    <?php foreach ($langs as $key => $item): ?>
                        <div class="tab-pane <?= ($key == 0) ? 'active' : '' ?>" id="tab_<?= $key ?>">
                            <p><b>Заголовок: </b> <br><?= $descriptions[$key]->title ?></p>
                            <p><b>Текст: </b> <br><?= $descriptions[$key]->description ?></p>
                            <p><b>Имя ссылки: </b> <br><?= $descriptions[$key]->link_name ?></p>
                            <p><b>Ссылка: </b> <br><?= $descriptions[$key]->link ?></p>
                        </div>
                        <!-- /.tab-pane -->
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</div>

