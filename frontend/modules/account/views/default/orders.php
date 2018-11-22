<?php

/* @var $this yii\web\View */

use common\models\CurrentTime;
use frontend\components\ThemeLinkPager;
use frontend\widgets\Breadcrumbs;
use \yii\helpers\Url;

$userTime = CurrentTime::getUserOffsetTime();
?>
<input type="hidden"
       value="<?= Url::to(['/account/orders']) ?>"
       id="js__location">
<section class="cabinet">
    <div class="container">
        <div class="cabinet__content">
            <div class="main-title">
                <h2><?= Yii::t('main', 'account') ?></h2>
            </div>
            <div class="cabinet__buttons">
                <a class="cabinet__button" href="<?= Url::to(['/account']) ?>/"><?= Yii::t('main', 'account') ?></a>
                <a class="cabinet__button is-active"
                   href="<?= Url::to(['/account/orders']) ?>"><?= Yii::t('main', 'orders_history') ?></a>
            </div>
            <div class="cabinet__body">
                <div class="cabinet__tabs">
                    <div class="cabinet__tab tab-history-of-orders is-active">
                        <div class="cabinet__tab-header">
                            <strong><?= Yii::t('main', 'sorting') ?></strong>
                            <div class="dropdown-main dropdown-main--sorting">
                                <div class="dropdown-main__header dropdown-main__header--js-click link-hover">
                                    <p><?= $orders_data['current_sort'] ?>↑↓</p>
                                    <span class="cf-arrow-down"></span>
                                </div>
                                <ul class="dropdown-main__body dropdown-main__body--sorting">
                                    <?php foreach ($orders_data['filters'] as $key => $filter): ?>
                                        <li class="link-hover <?= ($filter == $orders_data['current_sort']) ? "link-active" : "" ?>">
                                            <span class="js__changeOrderBy" data-val="<?= $filter ?>"
                                                  data-key="<?= $key ?>"><?= $filter ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="cabinet__table">
                            <div class="cabinet__table-tr">
                                <div class="cabinet__table-header">
                                    <div class="cabinet__table-item">
                                        <strong><?= Yii::t('main', 'order') ?></strong>
                                    </div>
                                    <div class="cabinet__table-item">
                                        <strong><?= Yii::t('main', 'date') ?></strong>
                                    </div>
                                    <div class="cabinet__table-item">
                                        <strong><?= Yii::t('main', 'sum') ?></strong>
                                    </div>
                                    <div class="cabinet__table-item">
                                        <strong><?= Yii::t('main', 'more') ?></strong>
                                    </div>
                                </div>
                            </div>
                            <?php if ($orders_data['orders']): ?>
                                <?php foreach ($orders_data['orders'] as $order): ?>
                                    <div class="cabinet__table-tr">
                                        <div class="cabinet__table-header">
                                            <div class="cabinet__table-item">
                                                <strong><?= $order['item']['id'] ?></strong>
                                            </div>
                                            <div class="cabinet__table-item">
                                                <span><?= date("H:i d.m.Y", $order['item']['created_at'] + $userTime) ?></span>
                                            </div>
                                            <div class="cabinet__table-item">
                                                <span><?= $order['item']['total_price'] . $orders_data['currency'] ?></span>
                                            </div>
                                            <div class="cabinet__table-item">
                                                <button class="cf-arrow-down"></button>
                                            </div>
                                        </div>
                                        <div class="cabinet__table-body">
                                            <?php foreach ($order['products'] as $product): ?>
                                                <div class="cabinet__table-items">
                                                    <div class="cabinet__table-item">
                                                        <p><a href="<?= Url::to(['/product']) ?>/<?= $product->slug?>"><?= $product->title ?></a></p>
                                                        <p><?= $product->title ?></p>
                                                    </div>
                                                    <div class="cabinet__table-item">
                                                        <p><?= $product->default_price ?></p>
                                                        <p><?= $product->count ?></p>
                                                    </div>
                                                    <div class="cabinet__table-item">
                                                        <p><?= $product['price'] . $orders_data['currency'] ?></p>
                                                    </div>
                                                    <div class="cabinet__table-item">
                                                        <p></p>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pagination—wrapper">
            <?= ThemeLinkPager::widget([
                'pagination' => $orders_data['pagination'],
                'prevPageCssClass' => 'prev',
                'nextPageCssClass' => 'next',
                'prevPageLabel' => '<i class="cf-prev"></i>',
                'nextPageLabel' => '<i class="cf-next"></i>',
                'maxButtonCount' => 8
            ]); ?>
        </div>
    </div>
</section>
