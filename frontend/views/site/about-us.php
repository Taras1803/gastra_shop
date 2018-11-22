<?php
use yii\helpers\Url;
?>
<section class="about">
    <div class="container">
        <div class="about__content">
            <div class="main-title">
                <h2><?= Yii::t('main', 'about_us') ?></h2>
                <p class="main-text main-text--md-lg">
                    <?= $pageContent['about_us_title'] ?>
                </p>
            </div>
            <div class="about__holder">
                <div class="about__inline about__inline--lg">
                    <img src="<?= Yii::$app->glide->createSignedUrl([
                        'glide/index',
                        'path' => 'images/' . $themeVariables['about_page_top_image'],
                    ], true) ?>" alt="">
                </div>
                <div class="about__description">
                    <div class="about__description-container">
                        <p class="main-text main-text--md-lg">
                            <?= $pageContent['about_us_text_in_square_right'] ?>
                        </p>
                        <a href="<?= Url::to(['/catalog/all']) ?>">
                            <button class="btn-border btn-border--whith-arrow cf-arrow-right">
                                <?= Yii::t('main', 'on_catalog') ?>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="about__inner">
                <div class="about__inline">
                    <p class="main-text main-text--md-lg">
                        <?= $pageContent['about_us_text_down_right'] ?>
                    </p>
                </div>
                <div class="about__inline">
                    <p class="main-text main-text--md-lg">
                        <?= $pageContent['about_us_text_down_left'] ?>
                    </p>
                </div>
            </div>
            <div class="about__inner">
                <div class="about__inline">
                    <img src="<?= Yii::$app->glide->createSignedUrl([
                        'glide/index',
                        'path' => 'images/' . $themeVariables['down_left_image'],
                    ], true) ?>" alt="">
                </div>
                <div class="about__inline">
                    <img src="<?= Yii::$app->glide->createSignedUrl([
                        'glide/index',
                        'path' => 'images/' . $themeVariables['down_right_image'],
                    ], true) ?>" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
