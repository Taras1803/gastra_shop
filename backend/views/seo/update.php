<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\News */

$this->title = 'Обновить SEO: №' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Настройки SEO', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'SEO №' . $model->id, 'url' => ['view', 'id' => $model->id]];
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