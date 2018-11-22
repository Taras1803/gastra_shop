<?php

use frontend\components\ThemeHelper;
use frontend\widgets\Breadcrumbs;
use yii\helpers\Url;
use common\models\Currency;

$currency = Currency::getCurrent();

?>

<section class="basket">
    <div class="container">
        <div class="basket__content">
            <div class="main-title">
                <h2><?= Yii::t('main', 'shopping_cart') ?></h2>
            </div>
            <?php if ($data): ?>
                <div class="basket__items">
                    <?php foreach ($data['products'] as $product_key => $product): ?>
                        <div class="basket__item">
                            <div class="basket__photo">
                                <a href="<?= Url::to(['/product']) ?>/<?= $product['slug'] ?>">
                                    <img src="<?= Yii::$app->glide->createSignedUrl([
                                        'glide/index',
                                        'path' => 'products/' . $product['image'],
                                        'w' => 225
                                    ], true) ?>" alt="<?= $product['title'] ?>">
                                </a>
                            </div>
                            <div class="basket__description">
                                <div class="basket__type"><?= $product['article'] ?></div>
                                <a href="<?= Url::to(['/product']) ?>/<?= $product['slug'] ?>">
                                    <div class="basket__name">
                                        <?= $product['title'] ?>
                                    </div>
                                </a>
                                <div class="basket__inline">
                                    <div class="basket__mass">
                                            <span class="basket__value">
                                                <?php if ($product['type'] == 2): ?>
                                                    <?= Yii::t('main', 'weight') ?>
                                                <?php else: ?>
                                                    <?= Yii::t('main', 'quantity') ?>
                                                <?php endif; ?>
                                            </span>
                                        <div class="dropdown-main">
                                            <div class="dropdown-main__header dropdown-main__header--js-click link-hover">
                                                <p class="js__productCount_view"><?= $product['counts'][$product['count']] ?></p>
                                                <span class="cf-arrow-down"></span>
                                            </div>
                                            <ul class="dropdown-main__body">
                                                <?php foreach ($product['counts'] as $key => $value): ?>
                                                    <li style="cursor: pointer">
                                                        <a onclick="basket.change_count(<?= $product_key ?>, <?= $key ?>)"
                                                           data-value="<?= $value ?>"
                                                           data-key="<?= $key ?>"><?= $value ?></a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="basket__price">
                                        <?php if ($product['action']): ?>
                                            <s><?= ThemeHelper::priceCalculation($product['price'], 0) ?><?= $currency['symbol'] ?></s><?= ThemeHelper::priceCalculation($product['price'], $product['action']) ?><?= $currency['symbol'] ?>
                                        <?php else: ?>
                                            <?= $product['price'] . $currency['symbol'] ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <button class="basket__delete link-hover"
                                        onclick="basket.remove(<?= $product_key ?>)">
                                    <span><?= Yii::t('main', 'remove') ?></span></button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <form action="" class="basket__form">
                    <div class="basket__form-holder">
                        <div class="basket__form-field">
                            <input type="text" name="" class="field-input field-promo"
                                   placeholder="<?= Yii::t('main', 'promo') ?>">
                            <button type="button" class="cf-arrow-right js_promo_button"
                                    style="margin-right: -50px"></button>
                            <p class="promo-error"></p>
                        </div>
                        <h3 id="js__sopping_total" data-price="<?= $data['totals'] ?>" data-currency="<?= $currency['symbol'] ?>"><?= $data['totals'] . $currency['symbol'] ?></h3>
                    </div>
                    <a href="<?= Url::to(['/checkout']) ?>" class="btn-yellow btn-yellow--whith-arrow cf-arrow-right">
                        <span><?= Yii::t('main', 'checkout_button') ?></span>
                    </a>
                </form>
            <?php else: ?>
                <p><?= Yii::t('main', 'basket_empty_text') ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>

