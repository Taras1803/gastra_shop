<?php

use \yii\helpers\Url;

?>

<section class="cabinet">
    <div class="container">
        <div class="cabinet__content">
            <div class="main-title">
                <h2><?= Yii::t('main', 'registration') ?></h2>
            </div>
        <div class="cabinet__buttons cabinet__buttons--left">
            <h4><?= vsprintf(Yii::t('main', 'already_account'),['<span><a class="withLine withLine--blue" href="' . Url::to(['/account/login']). '">', '</a></span>']) ?></h4>
        </div>
        <div class="cabinet__body">
            <div class="cabinet__tabs">
                <div class="cabinet__tab tab-personal-data is-active">
                    <div class="cabinet__tab-items">
                        <form action="<?= Url::to(['/account/ajax/sign-up']) ?>" class="registr__tab-items">
                            <div class="modal__items">
                                <div class="modal__item">
                                    <label for="field-email" class="field-label">E-mail*</label>
                                    <input type="email" class="field-input form-fields required" name="email"
                                           id="field-email">
                                </div>
                                <div class="modal__item">
                                    <label for="field-password"
                                           class="field-label"><?= Yii::t('main', 'password') ?>*</label>
                                    <input type="password" class="field-input form-fields required"
                                           name="password"
                                           id="field-password">
                                </div>
                                <div class="modal__item">
                                    <label for="field-repeat--password"
                                           class="field-label"><?= Yii::t('main', 'repeat_password') ?>*</label>
                                    <input type="password" class="field-input form-fields required"
                                           name="repeat_password" id="field-repeat--password">
                                </div>
                            </div>
                            <div class="modal__items">
                                <div class="modal__item">
                                    <label for="field-surname"
                                           class="field-label"><?= Yii::t('main', 'last_name') ?>*</label>
                                    <input type="text" class="field-input form-fields required"
                                           name="last_name">
                                </div>
                                <div class="modal__item">
                                    <label for="field-name"
                                           class="field-label"><?= Yii::t('main', 'first_name') ?>
                                        *</label>
                                    <input type="text" class="field-input form-fields required"
                                           name="first_name"
                                           id="field-name">
                                </div>
                                <div class="modal__item">
                                    <label for="field-name-father"
                                           class="field-label"><?= Yii::t('main', 'middle_name') ?></label>
                                    <input type="text" class="field-input" id="field-name-father" name=""
                                           placeholder="">
                                </div>
                                <div class="modal__item">
                                    <label for="field-phone"
                                           class="field-label"><?= Yii::t('main', 'phone') ?></label>
                                    <input type="text" class="field-input form-fields" name="phone"
                                           id="field-tel"
                                           placeholder="+38">
                                </div>
                                <div class="modal__item">
                                    <label for="field-burn"
                                           class="field-label"><?= Yii::t('main', 'dob') ?></label>
                                    <input type="date" class="field-input unstyled form-fields" name="dob"
                                           id="field-born" placeholder="00.00.0000">
                                </div>
                                <div class="modal__item">
                                    <label for="field-city"
                                           class="field-label"><?= Yii::t('main', 'city') ?></label>
                                    <input type="text" class="field-input form-fields" name="city"
                                           id="field-city">
                                </div>
                                <div class="modal__item">
                                    <label for="field-address"
                                           class="field-label"><?= Yii::t('main', 'address') ?></label>
                                    <input type="text" class="field-input form-fields" name="address"
                                           id="field-adresse">
                                </div>
                                <div class="errorText"
                                     data-text="<?= Yii::t('main', 'fill_in_required_fields') ?>"><?= Yii::t('main', 'fill_in_required_fields') ?></div>
                                <div class="successText"></div>
                                <div class="modal__item">
                                    <span class="modal__ps">*-<?= Yii::t('main', 'required_fields') ?></span>
                                </div>
                            </div>
                            <button class="btn-border btn-border--whith-arrow cf-arrow-right js__submitForm"
                                    onclick="formSend.send(this, event, 'registration')"><?= Yii::t('main', 'registration') ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
