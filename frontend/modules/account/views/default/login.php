<?php

use frontend\widgets\Breadcrumbs;
use \yii\helpers\Url;

?>

<section class="cabinet">
    <div class="container">
        <div class="cabinet__content">
            <div class="main-title">
                <h2><?= Yii::t('main', 'login') ?></h2>
            </div>
            <div class="cabinet__buttons cabinet__buttons--left">
                <h4><?= vsprintf(Yii::t('main', 'no_account'), ['<span><a class="withLine withLine--blue" href="' . Url::to(['/account/registration']) . '">', '</a></span>']) ?></h4>
            </div>
            <div class="cabinet__body">
                <div class="cabinet__tabs">
                    <div class="cabinet__tab tab-personal-data is-active">
                        <?php if (isset($_GET['password']) && $_GET['password'] == 'changed'): ?>
                            <p class="passwordСhanged" style="color: #61a9b0"><?= Yii::t('main', 'password_changed_successfully') ?></p>
                        <?php endif; ?>
                        <div class="cabinet__tab-items">
                            <form action="<?= Url::to(['/account/ajax/login']) ?>" class="modal__form">
                                <div class="modal__items">
                                    <div class="modal__item">
                                        <label for="field-email" class="field-label">E-mail*</label>
                                        <input type="email" class="field-input form-fields required" name="email"
                                               id="field-email">
                                    </div>
                                    <div class="modal__item">
                                        <label for="field-password"
                                               class="field-label"><?= Yii::t('main', 'password') ?>*</label>
                                        <input type="password" class="field-input form-fields required" name="password"
                                               id="field-password">
                                    </div>
                                </div>
                                <div class="forget-pass"><span><a class="withLine withLine--blue"
                                                                  href="<?= Url::to(['/account/forgot']) ?>"><?= Yii::t('main', 'forgot_password') ?></a></span>
                                </div>
                                <div class="save-me">
                                    <label>
                                        <input class="checkbox form-fields" type="checkbox" name="remember_me">
                                        <span class="checkbox-custom"></span>
                                        <span><?= Yii::t('main', 'remember_me') ?></span>
                                    </label>
                                </div>
                                <div class="errorText"
                                     data-text="<?= Yii::t('main', 'fill_in_required_fields') ?>"><?= Yii::t('main', 'fill_in_required_fields') ?></div>
                                <div class="successText"></div>
                                <button class="btn-border btn-border--whith-arrow cf-arrow-right js__submitForm"
                                        onclick="formSend.send(this, event, 'login')"><?= Yii::t('main', 'enter') ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>