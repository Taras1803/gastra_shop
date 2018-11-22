<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\OrdersStatus */

$this->title = 'Добавить Статус Заказа';
$this->params['breadcrumbs'][] = ['label' => 'Статусы ЗАказов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-success" style="padding: 10px;">
    <div class="box-body">
        <div class="col-lg-4 col-lg-offset-4">

                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>

        </div>
    </div>
</div>
