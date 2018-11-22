<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Categories */

$this->title = 'Обновить категорию: №' . $model->id;
if($model->parent == 0)
    $this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
else
    $this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index', 'parent_id' => $model->parent]];

$this->params['breadcrumbs'][] = ['label' => '№' . $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="box box-success" style="padding: 10px;">
    <div class="box-body">
        <div class="col-lg-6 col-lg-offset-3">
            <?= $this->render('_form', [
                'model' => $model,
                'langs' => $langs,
                'descriptions' => $descriptions,
                'parents' => $parents,
            ]) ?>

        </div>
    </div>
</div>
