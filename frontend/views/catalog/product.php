<?php

use common\models\Options;
use frontend\components\HtmlHelper;
use frontend\components\ThemeHelper;
use \yii\helpers\Url;

$this->title = Yii::t('main', 'product');
$defaultWeight = ThemeHelper::getDefaultWeight();
?>
    <section class="card">
        <div class="container">
            <div class="card__content">
                <div class="card__product">
                    <div class="card__gallery">
                        <div class="card__thumbs">
                            <input hidden type="text" class="js__productCount" data-value="1">
                            <?php $images = explode("|", $product['images']) ?>
                            <?php if (isset($images[0])): ?>
                                <div class="card__thumb card__thumb--js-open active">
                                    <img src="<?= Yii::$app->glide->createSignedUrl([
                                        'glide/index',
                                        'path' => 'products/' . $images[0],
                                        'w' => 225
                                    ], true) ?>" alt="<?= $product['title'] ?>">
                                </div>
                            <?php endif; ?>

                            <?php if (isset($images[1])): ?>
                                <div class="card__thumb card__thumb--js-open">
                                    <img src="<?= Yii::$app->glide->createSignedUrl([
                                        'glide/index',
                                        'path' => 'products/' . $images[1],
                                        'w' => 225
                                    ], true) ?>" alt="<?= $product['title'] ?>">
                                </div>
                            <?php endif; ?>
                            <?php if (isset($images[2])): ?>
                                <div class="card__thumb card__thumb--js-open">
                                    <img src="<?= Yii::$app->glide->createSignedUrl([
                                        'glide/index',
                                        'path' => 'products/' . $images[2],
                                        'w' => 225
                                    ], true) ?>" alt="<?= $product['title'] ?>">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card__photos">
                            <div class="card__photo card__photo--js-open">
                                <img src="<?= Yii::$app->glide->createSignedUrl([
                                    'glide/index',
                                    'path' => 'products/' . $images[0],
                                    'w' => 225
                                ], true) ?>" alt="<?= $product['title'] ?>">
                            </div>
                        </div>
                    </div>
                    <div class="card__description">
                        <div class="card__name"><?= $product['title'] ?></div>
                        <div class="card__inline">
                            <div class="card__inner">
                                <strong><?= ($product['type_item'] == 2) ? Yii::t('main', 'weight') : Yii::t('main', 'quantity') ?></strong>
                                <div class="dropdown-main  js__dropdownContainer">
                                    <div class="dropdown-main__header dropdown-main__header--js-click link-hover">
                                        <p class="js__productCount_view"><?= $product['product_count'][1] ?></p>
                                        <input type="hidden" class="js__productCount" data-value="1">
                                        <span class="cf-arrow-down"></span>
                                    </div>

                                    <ul class="dropdown-main__body">
                                        <?php foreach ($product['product_count'] as $key => $value): ?>
                                            <li>
                                                <span data-value="<?= $value ?>" data-key="<?= $key ?>"
                                                      class="js__changeProductCount"><?= $value ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="card__inner">
                                <div class="card__price">
                                    <?php if ($product['action']): ?>
                                        <s><?= $product['price'] . " " . $currency['symbol'] ?></s><?= $product['action'] . " " . $currency['symbol'] ?>/<?= ($product['type_item'] == 2) ? $defaultWeight . Yii::t('main', 'gr') : "1" . Yii::t('main', 'pc') ?>
                                    <?php else: ?>
                                        <?= $product['price'] . " " . $currency['symbol'] ?>/<?= ($product['type_item'] == 2) ? $defaultWeight . Yii::t('main', 'gr') : "1" . Yii::t('main', 'pc') ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="card__actions product" data-id="<?= $product['id'] ?>">
                            <input hidden disabled type="text" class="field-mass1 js__productCount" id="field-mass1"
                                   placeholder="<?= $product['product_count'][1] ?>" data-value="1">
                            <span class="cf-wishlist cf-wishlist_fill js__addProductToWishlist<?= ($product['inWishlist']) ? ' active' : '' ?>"></span>
                            <button class="btn-yellow btn-yellow--basket cf-bag"
                                    onclick="basket.addSingle(event, this, <?= $product['id'] ?>)"><?= Yii::t('main', 'in_shopping_cart') ?></button>
                        </div>
                        <div class="card__white-layer">
                            <div class="card__list">
                                <ul>
                                    <?php foreach ($product['product_attributes'] as $attribute): ?>
                                        <li>
                                            <strong><?= $attribute['attribute_name'] ?>:</strong>
                                            <span><?= $attribute['value'] ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="card__text">
                                <p class="main-text main-text--md"><?= $product['description'] ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php if ($related_products): ?>
    <section class="items-line">
        <div class="container">
            <div class="items-line__content items-line__content--padding-top">
                <div class="main-title">
                    <h3><?= Yii::t('main', 'you_will_also_like') ?></h3>
                </div>
                <div class="items-line__items items-line__items--four">
                    <?php foreach ($related_products as $product): ?>
                        <?php HtmlHelper::product($product, [
                            'currency' => $currency['symbol']
                        ]) ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php if ($last_products): ?>
    <section class="items-line">
        <div class="container">
            <div class="items-line__content">
                <div class="main-title">
                    <h3><?= Yii::t('main', 'viewed_goods') ?></h3>
                </div>
                <div class="items-line__items items-line__items--four">
                    <?php foreach ($last_products as $product): ?>
                        <?php HtmlHelper::product($product, [
                            'currency' => $currency['symbol']
                        ]) ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>