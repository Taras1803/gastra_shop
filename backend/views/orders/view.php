<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Orders */

$this->title = 'Заказ №' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы клиентов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$totalsName = [
    'sub_total' => 'За товары',
    'promo_code' => 'Купон',
    'delivery' => 'Доставка',
    'total' => 'Итого',
];
?>
<input type="hidden" value="<?= $model->id ?>" id="orderID">
<input type="hidden" value="<?= $model->email ?>" id="js__userEmail">
<input type="hidden" value="<?= $orderData['user_lang'] ?>" id="js__userLang">
<div class="col-md-12 col-lg-12">
    <!-- Form Element sizes -->
    <div class="box box-success" style="padding: 10px;">
        <div class="box-body">
            <div id="w0" class="grid-view">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Адрес доставки</th>
                        <th>Детали заказа</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div style="overflow: auto;">
                                <ul style="width: 130px; text-align: right; display: inline-block; padding-left: 0px;">
                                    <?php if ($model->user_id > 0): ?>
                                        <li><b>ID Клиента: </b></li>
                                        <li><b>Клиент: </b></li>
                                        <li><b>Скидка: </b></li>
                                    <?php else: ?>
                                        <li><b>Клиент: </b></li>
                                    <?php endif; ?>
                                    <li><b>Email: </b></li>
                                    <?php if ($model->phone): ?>
                                        <li><b>Телефон: </b></li>
                                    <?php endif; ?>
                                    <?php if ($orderData['information']['country']): ?>
                                        <li><b>Страна: </b></li>
                                    <?php endif; ?>
                                    <?php if ($orderData['information']['city']): ?>
                                        <li><b>Город: </b></li>
                                    <?php endif; ?>
                                    <?php if ($orderData['information']['address']): ?>
                                        <li><b>Адрес: </b></li>
                                    <?php endif; ?>
                                    <?php if ($orderData['information']['np_detachment']): ?>
                                        <li><b>Отделение НП: </b></li>
                                    <?php endif; ?>
                                </ul>
                                <ul style="margin-left: 5px; padding-left: 0px; display: inline-block; padding-left: 0px;">
                                    <?php if ($model->user_id > 0): ?>
                                        <li><?= $model->user_id ?></li>
                                        <li><a href="/manager/user/view?id=<?= $model->user_id ?>"
                                               target="_blank"><?= $model->user_name ?></a></li>
                                        <li><?= $orderData['user_discount'] ?>%</li>
                                    <?php else: ?>
                                        <li><?= $model->user_name ?></li>
                                    <?php endif; ?>
                                    <li><?= $model->email ?></li>
                                    <?php if ($model->phone): ?>
                                        <li><?= $model->phone ?></li>
                                    <?php endif; ?>
                                    <?php if ($orderData['information']['country']): ?>
                                        <li><?= $orderData['information']['country'] ?></li>
                                    <?php endif; ?>
                                    <?php if ($orderData['information']['city']): ?>
                                        <li><?= $orderData['information']['city'] ?></li>
                                    <?php endif; ?>
                                    <?php if ($orderData['information']['address']): ?>
                                        <li><?= $orderData['information']['address'] ?></li>
                                    <?php endif; ?>
                                    <?php if ($orderData['information']['np_detachment']): ?>
                                        <li><?= $orderData['information']['np_detachment'] ?></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </td>
                        <td>
                            <div style="overflow: auto;">
                                <ul style="width: 130px; text-align: right; display: inline-block; padding-left: 0px; padding-top: 5px;">
                                    <li><b>Статус заказа: </b></li>
                                    <li><b>Сумма заказа: </b></li>
                                    <li><b>Способ доставки: </b></li>
                                    <li><b>Способ оплаты: </b></li>
                                    <li><b>Локация: </b></li>
                                    <li><b>Дата заказа: </b></li>
                                </ul>
                                <ul style="margin-left: 5px; padding-left: 0px; display: inline-block; padding-left: 0px; padding-top: 5px;">
                                    <li>
                                        <span class="colorStatus" style="background: <?= $orderData['order_status']->color ?>;"><?= $orderData['order_status']->ru ?></span>
                                    </li>
                                    <li><?= $model->total_price ?> <?= $orderData['currency'] ?></li>
                                    <li><?= $model->delivery_method ?></li>
                                    <li><?= $model->payment_method ?></li>
                                    <li><?= mb_strtoupper($orderData['user_lang']) ?></li>
                                    <li><?= $orderData['date'] ?></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <?php if ($orderData['information']['comment']): ?>
                <div class="row">
                    <p style="margin-left: 15px;"><b>Коментарий к
                            заказу: </b><?= $orderData['information']['comment'] ?></p>
                </div>
            <?php endif; ?>
        </div>
        <!-- /.box -->
    </div>
    <?php if ($model->status_id > 0): ?>
        <div class="box box-success collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">Подробная информация</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="display: none;">
                <div class="row">
                    <div class="col-sm-4 col-lg-4">
                        <h3>Детали стоимости:</h3>
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>Название</th>
                                <th>Цена</th>
                            </tr>
                            <?php foreach ($orderData['totals'] as $key => $item): ?>
                                <tr>
                                    <td><?= $totalsName[$key] ?></td>
                                    <td>
                                        <span><?= $item['price'] ?> <?= $orderData['currency'] ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-4 col-lg-4">
                        <h3>Детали доставки:</h3>
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>Название</th>
                                <th>Значение</th>
                            </tr>
                            <tr>
                                <td>Способ доставки</td>
                                <td><?= $model->delivery_method ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-4 col-lg-4">
                        <h3>Детали оплаты:</h3>
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>Название</th>
                                <th>Значение</th>
                            </tr>
                            <tr>
                                <td>Способ оплаты</td>
                                <td><?= $model->payment_method ?></td>
                            </tr>
                            <?php if ($orderData['payment']): ?>
                                <?php foreach ($orderData['payment'] as $item): ?>
                                    <tr>
                                        <td><?= $item['name'] ?></td>
                                        <td><?= $item['value'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="box box-success collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title">Товары</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="display: none;">
            <div class="row">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th style="width: 50px; text-align: center;">#</th>
                        <th style="text-align: center;">Изображение</th>
                        <th style="text-align: center;">Наименование</th>
                        <th style="text-align: center;">Кол-во</th>
                        <th style="text-align: center;">Сумма</th>
                    </tr>
                    <?php if ($orderData['products']): ?>
                        <?php foreach ($orderData['products'] as $key => $item): ?>
                            <tr>
                                <td align="center"><?= $key + 1 ?></td>
                                <td align="center"><a href="/manager/products/view?id=<?= $item['id'] ?>"><img
                                                style="width: 100px;" src="<?= $item['image'] ?>" alt="img"></a></td>
                                <td align="center">
                                    <a href="/manager/products/view?id=<?= $item['id'] ?>"><?= $item['title'] ?></a>
                                    <?php if ($item['attributes']): ?>
                                        <ul>
                                            <?php foreach ($item['attributes'] as $attr): ?>
                                                <li><?= $attr['attribute_name'] ?>: <?= $attr['value'] ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </td>
                                <td align="center"><?= $item['count'] ?></td>
                                <td align="center"><?= $item['price'] ?> <?= $orderData['currency'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="box box-success" style="padding: 10px;">
        <div class="box-body">
            <div class="row">
                <div class="col-md-8">
                    <h3>Изменить статус</h3>
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th style="width: 300px;">Статус</th>
                            <th>Комментарий</th>
                            <th>Действие</th>
                        </tr>
                        <tr>
                            <td>
                                <select style="width: 100%;" name="status" class="form-control item-data required">
                                    <?php foreach ($status_list as $item): ?>
                                        <option value="<?= $item->id ?>" <?= ($item->id == $model->status_id) ? 'selected' : '' ?>><?= $item->ru ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <textarea rows="2" style="width: 100%;" name="comment"
                                          class="form-control item-data"></textarea>
                            </td>
                            <td>
                                <a href="#" id="js__changeOrderStatus" class="btn btn-primary">Изменить</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <h3>История статусов</h3>
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th style="width: 50px">#</th>
                            <th>Статус</th>
                            <th>Дата</th>
                            <th>Отправлено</th>
                            <th>Комментарий</th>
                            <th></th>
                        </tr>
                        <?php if ($orderData['status_history']): ?>
                            <?php foreach ($orderData['status_history'] as $key => $item): ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><span class="colorStatus"
                                              style="background: <?= $item['color'] ?>;"><?= $item['name'] ?></span>
                                    </td>
                                    <td><?= $item['date'] ?></td>
                                    <td><?= $item['send'] ?></td>
                                    <td><?= $item['comment'] ?></td>
                                    <td>
                                        <a href="#" style="font-size: 22px;" data-id="<?= $item['id'] ?>"
                                           class="js__sendOrderStatus" title="Отправить клиенту">
                                            <i class="fa fa-fw fa-envelope"></i>
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
    </div>
</div>
<div class="clearfix"></div>

<style>

    table ul li {
        list-style: none;
    }
</style>
