<?php

/* @var $this yii\web\View */

use \frontend\components\HtmlHelper;
use frontend\components\ThemeHelper;
use frontend\widgets\BannerWidget;
use yii\helpers\Url;
$this->title = Yii::$app->params['site_name'];
?>
<?= BannerWidget::widget() ?>
<section class="about-us">
    <div class="container">
        <div class="about-us__content">
            <div class="about-us__holder">
                <div class="about-us__description">
                    <div class="main-title">
                        <h2><?= Yii::t('main', 'about_us') ?></h2>
                    </div>
                    <div class="about-us__text">
                        <p class="main-text main-text--md-lg"><?= $about_text ?></p>
                    </div>
                </div>
                <div class="about-us__image" style="background-image: url('<?= Yii::$app->glide->createSignedUrl([
                    'glide/index',
                    'path' => 'images/' . $about_image,
                ], true) ?>');"></div>
            </div>
        </div>
    </div>
</section>
<section class="items-line items-line--with-decor">
    <div class="container">
        <div class="items-line__content">
            <div class="main-title">
                <h2><?= Yii::t('main', 'sale') ?></h2>
            </div>
            <div class="items-line__items items-line__items--four">
                <?php if ($action_products): ?>
                    <?php foreach ($action_products as $product): ?>
                        <?php HtmlHelper::product($product, [
                                'currency' => \common\models\Currency::getCurrent()['symbol']
                        ]) ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="main-center">
                <a href="catalog/all" class="btn-border btn-border--whith-arrow cf-arrow-right"><?= Yii::t('main', 'on_catalog') ?></a>
            </div>
        </div>
    </div>
</section>

<section class="blog-line">
    <div class="container">
        <div class="blog-line__content">
            <div class="main-title">
                <h2><?= Yii::t('main', 'blog') ?></h2>
            </div>
            <div class="blog-line__items">
                <?php if ($news): ?>
                    <?php foreach ($news as $key => $item): ?>
                        <?php $description = $item->getNewsDescriptions()->one(); ?>
                        <div class="blog-line__item <?php if (($key % 2) != 0): ?> blog-line__item--right <?php endif; ?>">
                            <a href="<?= Url::to(['/blog']) ?>/<?= $item->slug ?>" class="blog-line__image"
                                <?php $images = explode("|", $item->images) ?>
                               style="background-image: url('<?= Yii::$app->glide->createSignedUrl([
                                   'glide/index',
                                   'path' => 'blog/' . $images[0],
                               ], true) ?>');"></a>
                            <div class="blog-line__description">
                                <a href="<?= Url::to(['/blog']) ?>/<?= $item->slug ?>"> <?= $description->title ?></a>
                                <p class="main-text main-text--md-lg"> <?= $description->short_description ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="main-center">
                <a href="<?= Url::to(['/catalog/all']) ?>" class="btn-border btn-border--whith-arrow cf-arrow-right"><?= Yii::t('main', 'on_catalog') ?></a>
            </div>
        </div>
    </div>
</section>