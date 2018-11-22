<?php

use common\models\Categories;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
$status_list = Categories::getStatus();
?>
<div class="box box-success" style="padding: 10px;">
    <div class="box-body">
        <div class="page-content-index">

            <p class="pull-right">
                <?php if (isset($_GET['parent_id']) && $_GET['parent_id']): ?>
                    <?= Html::a('Предыдущая', ['index', 'parent_id' => $prev], ['class' => 'btn btn-primary']) ?>
                <?php endif; ?>
                <?= Html::a('Добавить категорию', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <div id="w0" class="grid-view">
                <div class="summary">Showing <b><?= count($categories) ?></b> item(s)</div>
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Изображение</th>
                        <th>Название</th>
                        <th>Ссылка</th>
                        <th>Кол-во подкатегорий</th>
                        <th>Кол-во товаров</th>
                        <th>Порядок Сортировки</th>
                        <th>Статус</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($categories): ?>
                        <?php foreach ($categories as $key => $category): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <?php $images = explode("|", $category['data']->image); ?>
                                <td>
                                    <img src="<?= Yii::$app->glide->createSignedUrl([
                                        'glide/index',
                                        'path' => 'categories/' . $images[0],
                                        'w' => 120
                                    ], true) ?>"  style="max-width: 120px; max-height: 120px;"/>
                                </td>
                                <td><?= $category['description']->name ?></td>
                                <td><?= $category['data']->slug ?></td>
                                <?php if ($category['countChild']): ?>
                                    <td style="text-align: center;"><span
                                                style="font-size: 17px;font-weight: 500;"><?= $category['countChild'] ?></span>
                                        <a href="/manager/categories/index?parent_id=<?= $category['data']->id ?>"><i
                                                    class="fa fa-fw fa-list"></i></a></td>
                                <?php else: ?>
                                    <td style="text-align: center;"><span
                                                style="font-size: 17px;font-weight: 500;"><?= $category['countChild'] ?></span>
                                    </td>
                                <?php endif; ?>
                                <td style="text-align: center;"><span
                                            style="font-size: 17px;font-weight: 500;"><?= $category['countProducts'] ?></span>
                                </td>
                                <td><?= $category['data']->sort ?></td>
                                <td><?= $status_list[$category['data']->status] ?></td>
                                <td>
                                    <a href="/manager/categories/view?id=<?= $category['data']->id ?>" title="View"
                                       aria-label="View">
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                    </a>&nbsp;&nbsp;
                                    <a href="/manager/categories/update?id=<?= $category['data']->id ?>" title="Update"
                                       aria-label="Update">
                                        <span class="glyphicon glyphicon-pencil"></span></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
