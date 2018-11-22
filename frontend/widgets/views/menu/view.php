<?php

use common\models\Currency;
use frontend\components\HtmlHelper;
use \yii\helpers\Url;

$currency = Currency::getCurrent();

if ($currentLanguage->url == 'ru')
    $homeUrl = '/';
else
    $homeUrl = '/' . $currentLanguage->url . '/';

?>

<header class="header">
    <div class="header__content">
        <button class="header__burger">
            <span></span>
        </button>
        <?php if (Yii::$app->controller->getRoute() == 'site/index'): ?>
            <div class="header__logo header__logo--main">
                <img src="/images/logo.svg" alt="">
            </div>
        <?php else: ?>
            <a href="<?= $homeUrl ?>" class="header__logo">
                <img src="/images/logo.svg" alt="">
            </a>
        <?php endif; ?>
        <div class="header__holder">
            <div class="header__top">
                <div class="header__inner">
                    <ul class="header__phones">
                        <li>
                            <a href="tel:<?= str_replace(["(", ")", " ", "-"], "", $theme_variables['phone_1']) ?>"
                               class="main-text main-text--big link-hover"><span><?= $theme_variables['phone_1'] ?></span></a>
                        </li>
                        <li>
                            <a href="tel:<?= str_replace(["(", ")", " ", "-"], "", $theme_variables['phone_2']) ?>"
                               class="main-text main-text--big link-hover"><span><?= $theme_variables['phone_2'] ?></span></a>
                        </li>
                    </ul>
                </div>
                <div class="header__inner">
                    <ul class="header__actions">
                        <?php if (Yii::$app->user->isGuest): ?>
                            <li class="header__sign">
                                <a href="#" class="link-hover btn-open-modal">
                                    <span class="main-text main-text--big"><?= Yii::t('main', 'login_registr') ?></span>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="header__sign">
                                <a href="<?= Url::to(['/account']) . '/' ?>"><span
                                            class="main-text main-text--big"><?= Yii::t('main', 'account') ?></span></a>
                            </li>
                            <li class="header__sign">
                                <a href="#" class="link-hover js__userLogout"><?= Yii::t('main', 'logout') ?><span
                                            class="main-text main-text--big"><?= Yii::t('main', 'logout') ?></span></a>
                            </li>
                        <?php endif; ?>
                        <li>
                            <a href="<?= Url::to(['/catalog/wishlist']) ?>" class="link-hover">
                                <span class="cf-wishlist"></span>
                                <span class="h_number" id="js__wishlistCount"><?= $wishlistCount ?></span>
                            </a>
                        </li>
                        <li class="header__basket<?= ($basketCount) ? ' js--fill' : '' ?>">
                            <a href="<?= Url::to(['/shopping-cart']) ?>" class="link-hover">
                                <span class="cf-bag"></span>
                                <span class="h_number js__basketProductsCount"><?= $basketCount ?></span>
                            </a>
                            <div class="basket-drop is-full">
                                <div class="basket-drop__steps js__miniCartContainer">
                                    <?php if (!$basketData): ?>
                                        <div class="basket-drop__empty">
                                            <div class="basket-drop__title"><?= Yii::t('main', 'basket_empty_text') ?></div>
                                            <div class="basket-drop__bottom">
                                                <a href="<?= Url::to(['/catalog/all']) ?>"
                                                   class="btn-border"><span><?= Yii::t('main', 'on_catalog') ?></span></a>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="basket-drop__full">
                                            <div class="basket-drop__items scrollbar">
                                                <?php foreach ($basketData['products'] as $key => $product): ?>
                                                    <?php HtmlHelper::productInBasket($product, [
                                                        'currency' => $currencyData['current']['symbol'],
                                                        'key' => $key,
                                                    ]) ?>
                                                <?php endforeach; ?>
                                            </div>
                                            <div class="basket-drop__bottom">
                                                <strong><?= Yii::t('main', 'total_cost') ?>
                                                    <span><?= $basketData['totals'] . $currency['symbol'] ?></span></strong>
                                                <a href="<?= Url::to(['/checkout']) ?>"
                                                   class="btn-border btn-border--whith-arrow cf-arrow-right"><span><?= Yii::t('main', 'checkout_button') ?></span></a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>
                        <li class="header__lang">
                            <div class="dropdown-main dropdown-main--lang">
                                <div class="dropdown-main__header link-hover">
                                    <span class="cf-lang"></span>
                                    <p style="text-transform: uppercase;"><?= $currentLanguage->url ?>
                                        \<?= $currencyData['current']['code'] ?></p>
                                    <span class="cf-arrow-down"></span>
                                </div>
                                <ul class="dropdown-main__body dropdown-main__body--lang">
                                    <li>
                                        <strong><?= Yii::t('main', 'language') ?></strong>
                                    </li>
                                    <?php foreach ($langs as $lang): ?>
                                        <?php if ($lang->url == $currentLanguage->url): ?>
                                            <li class="link-active">
                                                <span class="link-hover " style="cursor: default;padding-left: 0;"><span style="cursor: default;"><?= $lang->name ?></span></span>
                                            </li>
                                        <?php else: ?>
                                            <li class="link-hover">
                                                <a
                                                   href="<?= (Yii::$app->getRequest()->getLangUrl() == '/' && $lang->url == 'ru') ? '/' : str_replace('/ru', '', '/' . $lang->url) . Yii::$app->getRequest()->getLangUrl() ?>"><span><?= $lang->name ?></span></a>
                                            </li>
                                        <?php endif; ?>

                                    <?php endforeach; ?>
                                    <li class="li-border">
                                        <strong><?= Yii::t('main', 'currency') ?></strong>
                                    </li>
                                    <?php foreach ($currencyData['list'] as $currency): ?>

                                        <?php if ($currency->id == $currencyData['current']['id']): ?>
                                            <li class="link-hover link-active">
                                                <span class="js__setCurrency" style="cursor:default;"
                                                   data-id="<?= $currency->id ?>"><?= $currency->code ?></span>
                                            </li>
                                        <?php else: ?>
                                            <li class="link-hover">
                                                <a href="#" class="js__setCurrency"
                                                   data-id="<?= $currency->id ?>"><?= $currency->code ?></a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="header__bottom">
                <div class="header__inner">
                    <ul class="header__menu header__menu--left">
                        <?php foreach ($categories_menu as $category): ?>
                            <li class="header__menu-drop">
                                <a href="<?= $category['link'] ?>"
                                   class="link-hover <?php if ($category['active']): ?> link-active <?php endif; ?>">
                                    <span><?= $category['title'] ?></span>
                                    <i class="cf-arrow-down"></i>
                                </a>
                                <div class="header__menu-dropdown">
                                    <ul>
                                        <?php if ($category['subCategories']): ?>
                                            <?php foreach ($category['subCategories'] as $subCategory): ?>
                                                <li>
                                                    <a href="<?= $subCategory['link'] ?>"
                                                       class="main-text main-text--md link-hover">
                                                        <span><?= $subCategory['title'] ?></span>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                    <div class="header__menu-image"
                                         style="background-image: url('<?= Yii::$app->glide->createSignedUrl([
                                             'glide/index',
                                             'path' => 'categories/' . $category['image'],
                                         ], true) ?>');"></div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                        <li>
                            <div class="header__search">
                                <span class="bb-search"></span>
                                <form action="<?= Url::to(['/search']) ?>" class="header__search-form js__searchForm">
                                    <input type="text" placeholder="<?= Yii::t('main', 'search') ?>"
                                           name="q" value="<?= $_GET['q'] ?>">
                                    <button class="bb-arrow-lg-right js__sendSearchForm"></button>
                                </form>
                            </div>
                            <div class="link-hover header__search">
                                <span class="cf-search bb-search"></span>
                                <form action="<?= Url::to(['/search']) ?>" class="header__search-form js__searchFor">
                                    <input type="text" placeholder="<?= Yii::t('main', 'search') ?>"
                                           name="q" value="<?= $_GET['q'] ?>">
                                    <button class="bb-arrow-lg-right js__sendSearchForm"><?= Yii::t('main', 'search') ?></button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="header__inner">
                    <ul class="header__menu header__menu--right">
                        <?php foreach ($rightMenu as $item): ?>
                            <li>
                                <a href="<?= $item['link'] ?>" class="link-hover">
                                    <span><?= $item['title'] ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<nav class="mobile-menu">
    <div class="mobile-menu__top">
        <ul class="items-main-menu">
            <?php foreach ($mobileMenu as $item): ?>
                <li>
                    <a href="<?= $item['link'] ?>" class="link-hover">
                        <span><?= $item['title'] ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="mobile-menu__bottom">
        <div class="mobile-menu__inner">
            <ul class="mobile-menu__phones">
                <li>
                    <a href="tel:<?= str_replace(["(", ")", " ", "-"], "", $theme_variables['phone_1']) ?>"
                       class="main-text main-text--big link-hover"><span><?= $theme_variables['phone_1'] ?></span></a>
                </li>
                <li>
                    <a href="tel:<?= str_replace(["(", ")", " ", "-"], "", $theme_variables['phone_2']) ?>"
                       class="main-text main-text--big link-hover"><span><?= $theme_variables['phone_2'] ?></span></a>
                </li>
            </ul>
        </div>

        <div class="mobile-menu__inner">
            <?php if (Yii::$app->user->isGuest): ?>
                <a href="#" class="link-hover btn-open-modal">
                    <span class="main-text main-text--big"><?= Yii::t('main', 'login_registr') ?></span>
                </a>
            <?php else: ?>
                <a href="<?= Url::to(['/account']) . '/' ?>" class="link-hover">
                    <span class="main-text main-text--big"><?= Yii::t('main', 'account') ?></span>
                </a> &nbsp;&nbsp;
                <a href="#" class="link-hover js__userLogout">
                    <span class="main-text main-text--big"><?= Yii::t('main', 'logout') ?></span>
                </a>

            <?php endif; ?>
        </div>
        <div class="mobile-menu__inner mobile-menu__inner--lang">
            <ul class="cf-lang">
                <li>
                    <strong><?= Yii::t('main', 'language') ?></strong>
                </li>
                <?php foreach ($langs as $lang): ?>
                    <li class="<?= ($lang->url == $currentLanguage->url) ? 'link-active' : '' ?>">
                        <a href="<?= (Yii::$app->getRequest()->getLangUrl() == '/' && $lang->url == 'ru') ? '/' : str_replace('/ru', '', '/' . $lang->url) . Yii::$app->getRequest()->getLangUrl() ?>"><?= $lang->name ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <ul>
                <li>
                    <strong><?= Yii::t('main', 'currency') ?></strong>
                </li>
                <?php foreach ($currencyData['list'] as $currency): ?>
                    <li class="<?= ($currency->id == $currencyData['current']['id']) ? 'link-active' : '' ?>">
                        <a href="#" class="link-hover js__setCurrency"
                           data-id="<?= $currency->id ?>"><span><?= $currency->code ?></span></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>