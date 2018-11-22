<?php

use frontend\widgets\Breadcrumbs;
use frontend\widgets\CommentWidget;
use \yii\helpers\Url;

$this->title = Yii::t('main', 'single');


?>
<section class="blog-intro">
    <div class="container">
        <div class="blog-intro__content">
            <div class="main-title">
                <h3><?= $description->title ?></h3>
            </div>
            <div class="blog-intro__inner">
                <div class="blog-intro__inline blog-intro__inline--lg">
                    <div class="blog-intro__date"> <?= date("d/m/Y", $article->created_at) ?></div>
                    <p class="main-text main-text--md-lg">
                        <?= $description->description ?>
                    </p>
                </div>
                <div class="blog-intro__inline blog-intro__inline--sm">
                    <?php if ($images[1]): ?>
                        <img src="<?= Yii::$app->glide->createSignedUrl([
                            'glide/index',
                            'path' => 'blog/' . $images[1],
                        ], true) ?>" alt="<?= $description->title ?>">
                    <?php endif; ?>
                </div>
                <div class="blog-intro__inline blog-intro__inline--exxtlg">

                    <img src="<?= Yii::$app->glide->createSignedUrl([
                        'glide/index',
                        'path' => 'blog/' . $images[0],
                    ], true) ?>" alt="<?= $description->title ?>">
                </div>
            </div>
            <div class="blog-intro__pagination">
                    <a href="<?= Url::to(['/blog']) ?>/<?= $prev->slug ?>" class="link-hover">
                        <span class="cf-arrow-right"><?= Yii::t('main', 'prew_news') ?></span>
                    </a>
                    <a href="<?= Url::to(['/blog']) ?>/<?= $next->slug ?>" class="link-hover">
                        <span class="cf-arrow-right"><?= Yii::t('main', 'next_news') ?></span>
                    </a>
            </div>
            <a href="<?= Url::to(['/blog']) ?>/"
               class="btn-border btn-border--whith-arrow cf-arrow-right"><?= Yii::t('main', 'all_news') ?></a>
        </div>
    </div>
</section>
