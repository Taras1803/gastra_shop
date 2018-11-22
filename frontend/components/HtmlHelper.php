<?php

namespace frontend\components;

use common\models\Currency;
use common\models\Options;
use common\models\UserWishlist;
use Yii;
use yii\helpers\Url;

class HtmlHelper
{

    static function singleArticle($item, $params = [])
    {
        $description = $item->getNewsDescriptions()->one();
        ?>
        <div class="items-line__item">
            <div class="news">
                <a href="<?= Url::to(['/blog']) ?>/<?= $item->slug ?>">
                    <?php $images = explode("|", $item->images) ?>
                    <img src="<?= Yii::$app->glide->createSignedUrl([
                        'glide/index',
                        'path' => 'blog/' . $images[0],
                        'w' => 556
                    ], true) ?>" alt="<?= $description->title ?>">
                </a>
                <div class="news__description">
                    <a href="<?= Url::to(['/blog']) ?>/<?= $item->slug ?>"> <?= $description->title ?> </a>
                    <span> <?= date("d/m/Y", $item->created_at) ?> </span>
                    <p class="main-text"> <?= $description->short_description ?></p>
                </div>
            </div>
        </div>
        <?php
    }

    static function product($product, $params = [])
    {
        $description = $product->getProductsDescriptions()->one();
        $inWishlist = UserWishlist::productInWishlist($product->id);
        $currency = Currency::getCurrent();
        $defaultWeight = ThemeHelper::getDefaultWeight();
        ?>

        <div class="items-line__item">
            <div class="product" data-id="<?= $product->id ?>" data-value="1">
                <div class="product__block">
                    <div class="product__inner">
                        <?php if ($product->images): ?>
                        <a href="<?= Url::to(['/product']) ?>/<?= $product->slug ?>" class="product__inner">
                            <?php $images = explode("|", $product->images) ?>
                            <img src="<?= Yii::$app->glide->createSignedUrl([
                                'glide/index',
                                'path' => 'products/' . $images[0],
                                'w' => 225
                            ], true) ?>" alt="<?= $description->title ?>">
                        </a>
                        <span class="cf-bag" onclick="basket.add(event, this, <?= $product->id ?>)"></span>
                        <span class="cf-wishlist cf-wishlist_fill js__addProductToWishlist<?= ($inWishlist) ? ' active' : '' ?>"></span>
                    </div>
                    <?php endif; ?>
                    <div class="product__description">
                        <a href="<?= Url::to(['/product']) ?>/<?= $product->slug ?>"
                           class="product__name main-text main-text--lg-sm link-hover">
                            <span><?= $description->title ?></span>
                        </a>
                        <?php if ($product->action): ?>
                            <strong class="product__price">
                                <s><?= ThemeHelper::priceCalculation($product->price, 0) ?><?= $currency['symbol'] ?></s><?= ThemeHelper::priceCalculation($product->price, $product->action) ?><?= $currency['symbol'] ?>
                                /<?= $defaultWeight . Yii::t('main', 'gr') ?>
                            </strong>
                        <?php else: ?>
                            <strong class="product__price">
                                <?= ThemeHelper::priceCalculation($product->price, 0) ?><?= $currency['symbol'] ?>
                                /<?= $defaultWeight . Yii::t('main', 'gr') ?>
                            </strong>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }


    static function wishListProduct($product, $params = [])
    {
        $description = $product->getProductsDescriptions()->one();
        $currency = Currency::getCurrent();
        $defaultWeight = ThemeHelper::getDefaultWeight();
        ?>
        <?php if ($product && $description): ?>
        <div class="items-line__item" data-id="<?= $product->id ?>">
            <div class="product">
                <?php if (!Yii::$app->user->isGuest): ?>
                    <span class="main-text main-text--sm"><?= Yii::t('main', 'left') ?> <?= UserWishlist::getDays($product->id) ?>
                        <?= Yii::t('main', 'days') ?></span>
                <?php endif; ?>
                <div class="product__block">
                    <div class="product__inner">
                        <button class="product__delete main-text main-text--sm link-hover js__removeProductFromWishlist">
                            <span><?= Yii::t('main', 'remove') ?></span></button>
                        <a href="<?= Url::to(['/product']) ?>/<?= $product->slug ?>" class="product__inner">
                            <?php $images = explode("|", $product->images) ?>
                            <img src="<?= Yii::$app->glide->createSignedUrl([
                                'glide/index',
                                'path' => 'products/' . $images[0],
                                'w' => 225
                            ], true) ?>" alt="<?= $description->title ?>">
                        </a>
                        <span class="cf-bag"></span>
                    </div>
                    <div class="product__description">
                        <a href="<?= Url::to(['/product']) ?>/<?= $product->slug ?>"
                           class="product__name main-text main-text--lg-sm link-hover">
                            <span><?= $description->title ?></span>
                        </a>
                        <?php if ($product->action): ?>
                            <strong class="product__price">
                                <s><?= ThemeHelper::priceCalculation($product->price, 0) ?><?= $currency['symbol'] ?></s><?= ThemeHelper::priceCalculation($product->price, $product->action) ?><?= $currency['symbol'] ?>/<?= $defaultWeight . Yii::t('main', 'gr') ?>
                            </strong>
                        <?php else: ?>
                            <strong class="product__price">
                                <?= ThemeHelper::priceCalculation($product->price, 0) ?><?= $currency['symbol'] ?>/<?= $defaultWeight . Yii::t('main', 'gr') ?>
                            </strong>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
        <?php
    }

    static function productInBasket($product, $params = [])
    {
        ?>
        <?php if ($product): ?>
        <div class="basket-drop__item">
            <div class="basket-drop__photo">
                <a href="<?= Url::to(['/product/' . $product['slug']]) ?>"><img
                            src="<?= Yii::$app->glide->createSignedUrl([
                                'glide/index',
                                'path' => 'products/' . $product['image'],
                                'w' => 225
                            ], true) ?>" alt="<?= $product['title'] ?>"></a>
            </div>
            <div class="basket-drop__description">
                <div class="basket-drop__type"><?= $product['article'] ?></div>
                <div class="basket-drop__name"><?= $product['title'] ?></div>
                <div class="basket-drop__inline">
                    <div class="basket-drop__mass">
                        <span class="basket-drop__value"><?= ($product['type'] == 1) ? Yii::t('main', 'quantity') : Yii::t('main', 'weight') ?>
                            : <?= $product['counts'][$product['count']] ?></span>
                    </div>
                    <div class="basket-drop__price"><?= $product['price'] . $params['currency'] ?></div>
                </div>
                <button class="basket-drop__delete" onclick="basket.remove(<?= $params['key'] ?>)">x</button>
            </div>
        </div>
    <?php endif; ?>
        <?php
    }
}