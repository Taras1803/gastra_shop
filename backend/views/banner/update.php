<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Banner */

$this->title = 'Обновить баннер: №' .  $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Banners', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="box box-success" style="padding: 10px;">
    <div class="box-body">
        <div class="col-lg-8 col-lg-offset-2">
            <?= $this->render('_form', [
                'model' => $model,
                'langs' => $langs,
                'descriptions' => $descriptions,
            ]) ?>
        </div>
    </div>
</div>