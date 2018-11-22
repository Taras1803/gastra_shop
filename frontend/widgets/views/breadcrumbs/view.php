<?php

if ($language->url == 'ru')
    $homeUrl = '/';
else
    $homeUrl = '/' . $language->url . '/';
?>

<?php if (count($breadcrumbs) > 0): ?>
    <!--breadcrumbs-->
    <ul class="breadcrumbs">
        <li>
            <a href="<?= $homeUrl ?>"><?= Yii::t('main', 'main') ?></a>
        </li>
        <?php foreach ($breadcrumbs as $key => $item): ?>
            <?php if ($item['url']): ?>
                <li>
                    <a href="<?= $item['url'] ?>"><?= $item['label'] ?></a>
                </li>
            <?php else: ?>
                <li><span><?= $item['label'] ?></span></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
    <!--breadcrumbs-->

<?php endif; ?>
