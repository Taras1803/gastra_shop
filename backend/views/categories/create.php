<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Categories */

$this->title = 'Добавить категорию';
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
