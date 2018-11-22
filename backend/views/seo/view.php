<?php

use common\models\CurrentTime;use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\News */

$this->title = 'SEO №' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Настройки SEO', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'SEO №' . $model->id;
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
                   'slug'
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
