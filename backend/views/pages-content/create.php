<?php
/* @var $this yii\web\View */
/* @var $model common\models\PagesContent */

$this->title = 'Добавить Контент';
$this->params['breadcrumbs'][] = ['label' => 'Контент Страниц', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
