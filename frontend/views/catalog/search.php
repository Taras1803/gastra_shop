<?php

/* @var $this yii\web\View */

use frontend\components\HtmlHelper;
use frontend\components\ThemeLinkPager;
use frontend\widgets\Breadcrumbs;
use yii\helpers\Url;

?>
<input type="hidden"
       value="<?= Url::to(['/search?q=' . $q]) ?>"
       id="js__location">
<input type="hidden" value="<?= $catalog_data['max_product_price'] ?>" id="js__max_price">
<input type="hidden" value="search" id="js__search_identy">
<section class="catalog searchPage">
    <div class="container">
        <div class="catalog__content">
            <?php if ($catalog_data['products']): ?>
                <div class="catalog__top">
                    <div class="main-title">
                        <h1><?= Yii::t('main', 'search_result') ?>: <span><?= $q ?></span></h1>
                    </div>
                    <div style="margin:30px auto; max-width:1000px">
                        <div class="searchPage__control">
                            <label>
                                <input type="text" class="field-input form-fields js__searchInput" placeholder="<?= Yii::t('main', 'search_on') ?>" value='<?= $q ?>'>
                            </label>

                            <button class="btn-border btn-border--whith-arrow cf-arrow-right js__searchButton">
                                <span><?= Yii::t('main', 'search') ?></span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="items-line__header">
                    <div class="items-line__inner">
                        <div class="items-line__inline">
                        </div>
                        <div class="items-line__inline">
                            <strong><?= Yii::t('main', 'price') ?></strong>
                            <div class="dropdown-price">
                                <div class="dropdown-main__header dropdown-main__header--js-click link-hover">
                                    <?php if ($catalog_data['min_price'] || $catalog_data['max_price']): ?>
                                        <p><?= $catalog_data['min_price'] . '-' . $catalog_data['max_price'] . $catalog_data['currency'] ?></p>
                                    <?php endif; ?>
                                    <span class="cf-arrow-down"></span>
                                </div>
                                <div class="dropdown-price__body js__priceContainer">
                                    <div class="dropdown-price__string">
                                        <label for="from-input">
                                            <span><?= Yii::t('main', 'from') ?></span>
                                            <input type="number" name="min_price" id="from-input"
                                                   placeholder="0<?= $catalog_data['currency'] ?>"
                                                   class="field-input t"
                                                   value="<?= $catalog_data['min_price'] ?>">
                                        </label>
                                        </label>
                                        <label for="before-input">
                                            <span><?= Yii::t('main', 'to') ?></span>
                                            <input type="number" name="max_price" id="before-input"
                                                   placeholder="999<?= $catalog_data['currency'] ?>"
                                                   class="field-input t"
                                                   value="<?= $catalog_data['max_price'] ?>">
                                        </label>
                                    </div>
                                    <button class="btn-yellow js__applyPriceFilter">
                                    <span>
                                        <?= Yii::t('main', 'apply') ?>
                                    </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="items-line__inner">
                        <div class="items-line__inline">
                            <strong><?= Yii::t('main', 'sorting') ?></strong>
                            <div class="dropdown-main dropdown-main--sorting">
                                <div class="dropdown-main__header dropdown-main__header--js-click link-hover">
                                    <p data-key="<?= $catalog_data['order_by'] ?>" disabled id="js__getFilter">
                                        <?= $catalog_data['filters'][$catalog_data['order_by']] ?>
                                    </p>
                                    <span class="cf-arrow-down"></span>
                                </div>
                                <ul class="dropdown-main__body dropdown-main__body--sorting">
                                    <?php foreach ($catalog_data['filters'] as $key => $filter): ?>
                                        <li class="link-hover <?php if ($key == $catalog_data['order_by']): ?> link-active <?php endif; ?>">
                                       <span class="js__changeOrderBy" data-val="<?= $filter ?>"
                                             data-key="<?= $key ?>"><?= $filter ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="items-line__items items-line__items--four">
                    <?php foreach ($catalog_data['products'] as $product): ?>
                        <?php HtmlHelper::product($product, [
                            'currency' => $catalog_data['currency']
                        ]) ?>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="js__notFound"><?= Yii::t('main', 'products_not_found') ?> <?= $q ?></p>
            <?php endif; ?>
        </div>
        <div class="pagination—wrapper">
            <?= ThemeLinkPager::widget([
                'pagination' => $catalog_data['pagination'],
                'prevPageCssClass' => 'prev',
                'nextPageCssClass' => 'next',
                'prevPageLabel' => '<i class="cf-prev"></i>',
                'nextPageLabel' => '<i class="cf-next"></i>',
                'maxButtonCount' => 8
            ]); ?>
        </div>
    </div>
</section>