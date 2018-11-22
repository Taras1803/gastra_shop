<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = Yii::$app->params['site_name'];
?>
<footer class="footer">
    <div class="container">
        <div class="footer__content">
            <div class="footer__inners">
                <div class="footer__inner">
                    <a href="<?= $menu['about_us']['link'] ?>"><?= $menu['about_us']['title'] ?></a>
                    <p class="main-text main-text--sm footer-hidden"><?= $page_content['footer_about_us'] ?></p>
                </div>
                <div class="footer__inner">
                    <a href="<?= $menu['payment_delivery']['link'] ?>"><?= $menu['payment_delivery']['title'] ?></a>
                    <p class="main-text main-text--sm footer-hidden"><?= $page_content['footer_payment_delivery'] ?></p>
                </div>
                <div class="footer__inner">
                    <a href="<?= $menu['contacts']['link'] ?>"><?= $menu['contacts']['title'] ?></a>
                    <ul class="footer-hidden">
                        <li class="main-text main-text--sm"><?= Yii::t('main', 'tel') ?>: <a
                                    href="tel:<?= str_replace(["(", ")", " ", "-"], "", $theme_variables['phone_1']) ?>"
                                    class="link-hover main-text main-text--sm"><span><?= $theme_variables['phone_1'] ?></span></a>
                        </li>
                        <li class="main-text main-text--sm"><?= Yii::t('main', 'tel') ?>: <a
                                    href="tel:<?= str_replace(["(", ")", " ", "-"], "", $theme_variables['phone_2']) ?>"
                                    class="link-hover main-text main-text--sm"><span><?= $theme_variables['phone_2'] ?></span></a>
                        </li>
                    </ul>
                    <span class="main-text main-text--sm footer-hidden"><?= $page_content['footer_address'] ?></span>
                </div>
                <div class="footer__inner footer__inner--blog">
                    <a href="<?= $menu['blog']['link'] ?>"><?= $menu['blog']['title'] ?></a>
                    <div class="footer__blog footer-hidden">
                        <?php if ($news): ?>
                            <?php foreach ($news as $item): ?>
                                <?php $images = explode("|", $item->images) ?>
                                <?php $description = $item->getNewsDescriptions()->one(); ?>
                                <a href="<?= Url::to(['/blog']) ?>/<?= $item->slug ?>">
                                    <p>
                                        <img src="<?= Yii::$app->glide->createSignedUrl([
                                            'glide/index',
                                            'path' => 'blog/' . $images[0],
                                        ], true) ?>" alt="<?= $description->title ?>">
                                    </p>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="footer__inner">
                    <a href="<?= $menu['follow_us']['link'] ?>"><?= $menu['follow_us']['title'] ?></a>
                    <a href="<?= $theme_variables['instagram_link'] ?>" class="link-hover" target="_blank">
                        <span class="cf-inst"></span>
                        <span class="main-text main-text--sm"><?= $theme_variables['instagram_title'] ?></span>
                    </a>
                    <a href="<?= $theme_variables['fb_link'] ?>" class="link-hover" target="_blank">
                        <span class="cf-fb"></span>
                        <span class="main-text main-text--sm"><?= $theme_variables['fb_title'] ?></span>
                    </a>
                </div>
            </div>

            <div class="footer__copyright--bottom">
                <p class="footer__copyright">2018<?= (date("Y", time()) == '2018') ? '' : ' - ' . date("Y", time()) ?>,
                    All
                    right reserved</p>

                <div class="footer__copyright--cb">
                    <a href="https://ntsame.agency/?utm_source=gastrashop&utm_medium=referral&utm_campaign=createdByNTSame" target="_blank"><span class="footer__copyright--cb--txt">Created by </span> <span class="cf-logo_nts_o"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span></span></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    function createBy() {
        var linkWebSite = 'Created by: https://ntsame.agency';
        var stylesLink = [
            'background: #0A01BB;',
            'color: #43d1b6;',
            'padding: 3px 5px;',
            'font-size: 18px;'
        ].join('');

        console.log('%c%s', stylesLink, linkWebSite);
    };

    createBy();
</script>