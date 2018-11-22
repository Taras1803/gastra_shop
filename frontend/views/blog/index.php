<?php

use frontend\components\ThemeLinkPager;
use yii\helpers\Url;

$this->title = Yii::t('main', 'blog');
?>
<section class="blog">
    <div class="container">
        <div class="blog__content">
            <div class="main-title">
                <h3><?= Yii::t('main', 'blog') ?></h3>
            </div>
            <div class="blog__inners">
                <?php if ($articles): ?>
                    <?php foreach ($articles as $key => $article): ?>
                        <?php $images = explode("|", $article->images) ?>
                        <?php $description = $article->getNewsDescriptions()->one(); ?>
                        <?php if (($key % 2) != 0): ?>
                            <div class="blog__inner">
                                <div class="blog__inner--img">
                                    <a href="<?= Url::to(['/blog']) ?>/<?= $article->slug ?>">
                                        <img src="<?= Yii::$app->glide->createSignedUrl([
                                            'glide/index',
                                            'path' => 'blog/' . $images[0],
                                        ], true) ?>" alt="<?= $description->title ?>"></a>
                                </div>
                                <div class="blog__inner--content">
                                    <a href="<?= Url::to(['/blog']) ?>/<?= $article->slug ?>">
                                        <h4><?= $description->title ?></h4>
                                    </a>
                                    <div class="blog__inner--content-date">
                                        <?= date("d/m/Y", $article->created_at) ?>
                                    </div>
                                    <p><?= $description->short_description ?></p>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="blog__inner">
                                <div class="blog__inner--content">
                                    <a href="<?= Url::to(['/blog']) ?>/<?= $article->slug ?>">
                                    <h4><?= $description->title ?></h4>
                                    </a>
                                    <div class="blog__inner--content-date">
                                        <?= date("d/m/Y", $article->created_at) ?>
                                    </div>
                                    <p><?= $description->short_description ?></p>
                                </div>
                                <div class="blog__inner--img before--content">
                                    <a href="<?= Url::to(['/blog']) ?>/<?= $article->slug ?>">
                                    <img src="<?= Yii::$app->glide->createSignedUrl([
                                        'glide/index',
                                        'path' => 'blog/' . $images[0],
                                    ], true) ?>" alt="<?= $description->title ?>">
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="pagination—wrapper">
            <?= ThemeLinkPager::widget([
                'pagination' => $pagination,
                'prevPageCssClass' => 'prev',
                'nextPageCssClass' => 'next',
                'prevPageLabel' => '<i class="cf-prev"></i>',
                'nextPageLabel' => '<i class="cf-next"></i>',
                'maxButtonCount' => 8
            ]); ?>
        </div>
    </div>
</section>