<section class="hero">
    <div class="container">
        <div class="hero__content">
            <div class="hero__slider">
                <?php foreach ($banners as $baner): ?>
                <?php $description = $baner->getBannerDescriptions()->one(); ?>
                <div class="hero__slide">
                    <div class="hero__description">
                        <div class="hero__text">
                            <h1><?= $description->title ?></h1>
                            <p><?= $description->description ?></p>
                            <div class="hero__holder">
                                <a href="catalog/all" class="btn-border btn-border--whith-arrow cf-arrow-right"><?= $description->link_name ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="hero__container">
                        <div class="hero__image" style="background-image: url('<?= Yii::$app->glide->createSignedUrl([
                            'glide/index',
                            'path' => 'banners/' . $baner->image,
                        ], true) ?>');"></div>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</section>
