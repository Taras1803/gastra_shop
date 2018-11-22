<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PromoCodes */

$this->title = 'Добавить промокод';
$this->params['breadcrumbs'][] = ['label' => 'Промокоды', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-success" style="padding: 10px;">
    <div class="box-body">
        <div class="col-lg-8 col-lg-offset-2">
            <?= $this->render('_form', [
                'model' => $model,
                'langs' => $langs,
            ]) ?>
        </div>
    </div>
</div>