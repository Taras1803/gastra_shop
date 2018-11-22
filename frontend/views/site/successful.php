<?php
?>
<section class="thanks">
    <div class="container">
        <div class="thanks__content">
            <div class="thanks__body">
                <div class="thanks__items">
                    <div class="thanks__item-title"><h2><?= Yii::t('main', 'successful_title') ?></h2></div>
                    <div class="thanks__item-content">
                        <p><?= $successful_text ?></p>
                        <div class="thanks__item-content--button"><a href="<?= \yii\helpers\Url::to(['/catalog/all']) ?>" class="btn-border btn-border--whith-arrow cf-arrow-right"><?= Yii::t('main', 'on_catalog') ?></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
