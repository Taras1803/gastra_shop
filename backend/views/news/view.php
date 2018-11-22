<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\News */

$this->title = 'Статья №' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
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
            <?php $images = explode("|", $model->images) ?>
            <div class="row">
                <h4 style="margin-left: 15px;">Изображения</h4>
                <?php foreach ($images as $img): ?>
                    <div class="col-sm-4">
                        <img style="max-width: 90%; max-height: 150px;" src="<?= Yii::$app->glide->createSignedUrl([
                            'glide/index',
                            'path' => 'blog/' . $img,
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
                        'attribute' => 'slug',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return vsprintf('<a href="/blog/%s" target="_blank">%s</a>', [$searchModel->slug, $searchModel->slug]);
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel::getStatus()[$searchModel->status];
                        }
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
                            <p><b>Краткое описание: </b> <br><?= $descriptions[$key]->short_description ?></p>
                            <p><b>писание: </b> <br><?= $descriptions[$key]->description ?></p>
                            <p><b>Meta Заголовок: </b> <br><?= $descriptions[$key]->meta_title ?></p>
                            <p><b>Meta Описание: </b> <br><?= $descriptions[$key]->meta_description ?></p>
                            <p><b>Ключевые слова: </b> <br><?= $descriptions[$key]->meta_keywords ?></p>
                        </div>
                        <!-- /.tab-pane -->
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</div>
