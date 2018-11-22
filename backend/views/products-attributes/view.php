<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProductsAttributes */

$this->title = $model->ru;
$this->params['breadcrumbs'][] = ['label' => 'Атрибуты товаров', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
                    'slug',
                    'ru',
                    'uk',
                ],
            ]) ?>

            <h4>Значения атрибута:</h4>
            <table class="table table-striped table-bordered">
                <thead>
                <th>Значение</th>
                <th>Название RU (не обяз.)</th>
                <th>Название UK (не обяз.)</th>
                <th></th>
                </thead>
                <tr>
                    <td><input type="text" class="form-control item-data required" name="value" value=""></td>
                    <td><input type="text" class="form-control item-data" name="ru" value=""></td>
                    <td><input type="text" class="form-control item-data" name="uk" value=""></td>
                    <td style="text-align: center;">
                        <a href="#" style="font-size: 24px; color: #00a65a;" data-id="0" data-attributes_id="<?= $model->id ?>" class="js__saveAttributeValue">
                            <i class="fa fa-fw fa-plus-circle"></i>
                        </a>
                    </td>
                </tr>
                <tbody class="tbodyContent">
                <?php if($attribute_to_values): ?>
                    <?php foreach($attribute_to_values as $item): ?>
                        <tr>
                            <td><input type="value" class="form-control item-data required" name="value" value="<?= $item->value ?>"></td>
                            <td><input type="ru" class="form-control item-data" name="ru" value="<?= $item->ru ?>"></td>
                            <td><input type="en" class="form-control item-data" name="uk" value="<?= $item->uk ?>"></td>
                            <td style="text-align: center;">
                                <a href="#" style="font-size: 24px; color: blue;" data-id="<?= $item->id ?>" data-attributes_id="<?= $model->id ?>" class="js__saveAttributeValue">
                                    <i class="fa fa-fw fa-save"></i>
                                </a>
                                <a href="#" style="font-size: 24px; color: red;" class="js__removeAttributeValue" data-id="<?= $item->id ?>">
                                    <i class="fa fa-fw fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
