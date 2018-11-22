<?php

use common\models\CurrentTime;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Products */

$this->title = 'Товар №' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$userTime =CurrentTime::getUserOffsetTime();

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
                            'path' => 'products/' . $img,
                            'w' => 200
                        ], true) ?>" alt="img">
                    </div>
                <?php endforeach; ?>
            </div>
            <hr>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'price',
                    'action',
                    [
                        'attribute' => 'slug',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return vsprintf('<a href="/product/%s" target="_blank">%s</a>', [$searchModel->slug, $searchModel->slug]);
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
                        'attribute' => 'type',
                        'format' => 'raw',
                        'value' => function ($searchModel) {
                            return $searchModel::getTypes()[$searchModel->type];
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
                            <p><b>Название: </b> <br><?= $descriptions[$key]->title ?></p>
                            <p><b>Состав: </b> <br><?= $descriptions[$key]->consist ?></p>
                            <p><b>Описание: </b> <br><?= $descriptions[$key]->description ?></p>
                            <p><b>Meta Заголовок: </b> <br><?= $descriptions[$key]->meta_title ?></p>
                            <p><b>Meta Описание: </b> <br><?= $descriptions[$key]->meta_description ?></p>
                            <p><b>Ключевые слова: </b> <br><?= $descriptions[$key]->meta_keywords ?></p>
                        </div>
                        <!-- /.tab-pane -->
                    <?php endforeach; ?>
                </div>
            </div>

            <h4>Показывать в категориях:</h4>
            <table class="table table-striped table-bordered">
                <thead>
                <th>Категория</th>
                <th></th>
                </thead>
                <tr>
                    <td>
                        <select class="form-control item-data required" name="category_id">
                            <option value=""></option>
                            <?php foreach ($categories as $key => $category): ?>
                                <option value="<?= $key ?>"><?= $category ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td style="text-align: center;">
                        <a href="#" style="font-size: 24px; color: #00a65a;" data-id="0"
                           data-product_id="<?= $model->id ?>" class="js__saveProductToCategory">
                            <i class="fa fa-fw fa-plus-circle"></i>
                        </a>
                    </td>
                </tr>
                <tbody class="tbodyContent">
                <?php if ($productToCategory): ?>
                    <?php foreach ($productToCategory as $item): ?>
                        <tr>
                            <td>
                                <select class="form-control item-data required" name="category_id">
                                    <?php foreach ($categories as $key => $category): ?>
                                        <option value="<?= $key ?>" <?= ($item->category_id == $key) ? 'selected' : '' ?>><?= $category ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td style="text-align: center;">
                                <a href="#" style="font-size: 24px; color: blue;" data-id="<?= $item->id ?>"
                                   data-product_id="<?= $model->id ?>" class="js__saveProductToCategory">
                                    <i class="fa fa-fw fa-save"></i>
                                </a>
                                <a href="#" style="font-size: 24px; color: red;" class="js__removeProductToCategory"
                                   data-id="<?= $item->id ?>">
                                    <i class="fa fa-fw fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>

            <h4>Атрибуты товара:</h4>
            <table class="table table-striped table-bordered table-productAttributes">
                <thead>
                <th>Атрибут</th>
                <th>Значение</th>
                <th>Цена</th>
                <th>Сортировка</th>
                <th></th>
                </thead>
                <tr>
                    <td>
                        <select class="form-control item-data required" name="attribute_id">
                            <option value=""></option>
                            <?php foreach ($attributes as $key => $attribute): ?>
                                <option value="<?= $key ?>"><?= $attribute ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <select class="form-control item-data required" name="attribute_value_id">
                            <option value=""></option>
                        </select>
                    </td>
                    <td><input type="number" class="form-control item-data" name="price" value="0"></td>
                    <td><input type="number" class="form-control item-data" name="sort" value="0"></td>
                    <td style="text-align: center;">
                        <a href="#" style="font-size: 24px; color: #00a65a;" data-id="0"
                           data-product_id="<?= $model->id ?>" class="js__saveProductToAttribute">
                            <i class="fa fa-fw fa-plus-circle"></i>
                        </a>
                    </td>
                </tr>
                <tbody class="tbodyContent">
                <?php if ($productToAttributes): ?>
                    <?php foreach ($productToAttributes as $item): ?>
                        <tr>
                            <td>
                                <select class="form-control item-data required" name="attribute_id">
                                    <?php foreach ($attributes as $key => $attribute): ?>
                                        <option value="<?= $key ?>" <?= ($key == $item['data']->attribute_id)? 'selected' : '' ?>><?= $attribute ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <select class="form-control item-data required" name="attribute_value_id">
                                    <?php foreach ($item['values'] as $attribute): ?>
                                        <option value="<?= $attribute->id?>" <?= ($attribute->id == $item['data']->attribute_value_id)? 'selected' : '' ?>><?= $attribute->value . ' (' . $attribute->ru . ')' ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td><input type="number" class="form-control item-data" name="price" value="<?= $item['data']->price ?>"></td>
                            <td><input type="number" class="form-control item-data" name="sort" value="<?= $item['data']->sort ?>"></td>
                            <td style="text-align: center;">
                                <a href="#" style="font-size: 24px; color: blue;" data-id="<?= $item['data']->id ?>"
                                   data-product_id="<?= $model->id ?>" class="js__saveProductToAttribute">
                                    <i class="fa fa-fw fa-save"></i>
                                </a>
                                <a href="#" style="font-size: 24px; color: red;" class="js__removeProductToAttribute" data-id="<?= $item['data']->id ?>">
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
