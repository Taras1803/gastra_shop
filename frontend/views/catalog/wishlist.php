<?php

/* @var $this yii\web\View */

use common\models\Options;
use frontend\components\ThemeLinkPager;
use yii\data\Pagination;
use yii\helpers\Url;
use frontend\components\HtmlHelper;

?>
<section class="wishlist">
    <div class="container">
        <div class="wishlist__content">
            <div class="main-title">
                <h1><?= Yii::t('main', 'wishlist') ?></h1>
                <div class="white-layer">
                    <p class="main-text main-text--md-lg"><?= $wishlistText ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="items-line">
    <div class="container">
        <div class="items-line__content">
            <div class="items-line__items items-line__items--wishlist items-line__items--four">
                <?php if ($products['products']): ?>
                    <?php foreach ($products['products'] as $product): ?>
                        <?php HtmlHelper::wishListProduct($product) ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <p <?php if ($products['products']): ?>style="display: none"<?php endif; ?> class="js__notFound"><?= Yii::t('main', 'wl_not_found') ?></p>
            </div>
        </div>
        <?php if (!Yii::$app->user->isGuest): ?>
            <div class="pagination—wrapper">
                <?= ThemeLinkPager::widget([
                    'pagination' => $products['pagination'],
                    'prevPageCssClass' => 'prev',
                    'nextPageCssClass' => 'next',
                    'prevPageLabel' => '<i class="cf-prev"></i>',
                    'nextPageLabel' => '<i class="cf-next"></i>',
                    'maxButtonCount' => 8
                ]); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
