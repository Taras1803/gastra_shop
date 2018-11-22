<?php
Yii::$app->params['metaData'] = \common\models\Seo::getDataBySlug('404');
$lang = common\models\Lang::getCurrent();
if ($lang->url == 'ru')
    $homeUrl = '/';
else
    $homeUrl = '/' . $lang->url . '/';
?>

<section class="error">
    <div class="container">
        <div class="error__content">
            <div class="error__body">
                <div class="error__items">
                    <div class="error__item-title"><h2>4<span>0</span>4</h2></div>
                    <div class="error__item-content">
                        <p><?= Yii::t('main', 'something_went_wrong') ?></p>
                        <a href="<?= $homeUrl ?>" class="btn-border btn-border--whith-arrow cf-arrow-right"> <?= Yii::t('main', 'on_main') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>