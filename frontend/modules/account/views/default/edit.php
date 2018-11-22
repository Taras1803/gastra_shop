<?php

use common\models\Countries;
use \yii\helpers\Url;

$countries = Countries::getCountries()
?>

<section class="cabinet">
    <div class="container">
        <div class="cabinet__content">
            <div class="main-title">
                <h2><?= Yii::t('main', 'edit') ?></h2>
            </div>
            <div class="cabinet__buttons cabinet__buttons--left">
                <a href="<?= Url::to(['/account']) ?>/">
                    <div class="cabinet__button is-active"><?= Yii::t('main', 'account') ?></div>
                </a>
            </div>
            <div class="cabinet__body">
                <div class="cabinet__tabs">
                    <div class="cabinet__tab tab-personal-data is-active">
                        <div class="cabinet__tab-items">
                            <form action="<?= Url::to(['/account/ajax/update-info']) ?>" class="registr__tab-items">
                                <div class="cabinet__tab-item">
                                    <label for="field-fio"
                                           class="cabinet__tab-label"><?= Yii::t('main', 'first_name') ?>*</label>
                                    <div class="cabinet__tab-field">
                                        <input type="text" class="field-input form-fields required" name="first_name"
                                            <?php if ($user->first_name): ?> value="<?= $user->first_name ?>" <?php endif; ?>
                                               placeholder="">
                                    </div>
                                </div>
                                <div class="cabinet__tab-item">
                                    <label for="field-fio"
                                           class="cabinet__tab-label"><?= Yii::t('main', 'last_name') ?>*</label>
                                    <div class="cabinet__tab-field">
                                        <input type="text" class="field-input form-fields required" name="last_name"
                                            <?php if ($user->last_name): ?> value="<?= $user->last_name ?>" <?php endif; ?>
                                               placeholder="">
                                    </div>
                                </div>
                                <div class="cabinet__tab-item">
                                    <label for="field-fio"
                                           class="cabinet__tab-label"><?= Yii::t('main', 'middle_name') ?></label>
                                    <div class="cabinet__tab-field">
                                        <input type="text" class="field-input form-fields" name="middle_name"
                                            <?php if ($user->middle_name): ?> value="<?= $user->middle_name ?>" <?php endif; ?>
                                               placeholder="">
                                    </div>
                                </div>
                                <div class="cabinet__tab-item">
                                    <label for="field-date"
                                           class="cabinet__tab-label"><?= Yii::t('main', 'dob') ?></label>
                                    <div class="cabinet__tab-field">
                                        <input type="date" class="field-input unstyled form-fields" name="dob"
                                            <?php if ($user->dob): ?> value="<?= $user->dob ?>" <?php endif; ?>
                                               placeholder="00.00.0000">
                                    </div>
                                </div>
                                <div class="cabinet__tab-item">
                                    <label for="field-organization"
                                           class="cabinet__tab-label"><?= Yii::t('main', 'organization') ?></label>
                                    <div class="cabinet__tab-field">
                                        <input type="text" class="field-input form-fields" name="organization"
                                            <?php if ($user->organization): ?> value="<?= $user->organization ?>" <?php endif; ?>
                                               placeholder="">
                                    </div>
                                </div>
                                <div class="cabinet__tab-item">
                                    <label for="field-email" class="cabinet__tab-label">E-mail*</label>
                                    <div class="cabinet__tab-field">
                                        <input type="email" class="field-input form-fields required" name="email"
                                            <?php if ($user->email): ?> value="<?= $user->email ?>" <?php endif; ?>
                                               placeholder="">
                                    </div>
                                </div>
                                <div class="cabinet__tab-item">
                                    <label for="field-phone"
                                           class="cabinet__tab-label"><?= Yii::t('main', 'phone') ?></label>
                                    <div class="cabinet__tab-field">
                                        <input type="text" class="field-input form-fields" name="phone"
                                            <?php if ($user->phone): ?> value="<?= $user->phone ?>" <?php endif; ?>
                                               placeholder="">
                                    </div>
                                </div>
                                <div class="cabinet__tab-item">
                                    <label for="checkout_field-country"
                                           class="cabinet__tab-label"><?= Yii::t('main', 'country') ?></label>
                                    <div class="cabinet__tab-field">
                                        <div class="dropdown-main dropdown-main--select js__customDropDown">
                                            <div class="dropdown-main__header dropdown-main__header--js-click">
                                                <input type="text" class="field-input form-fields js_input_field"
                                                       name="country" value="<?= ($user->country) ? $user->country : $countries[1] ?>">
                                                <span class="cf-arrow-down"></span>
                                            </div>
                                            <ul class="dropdown-main__body">
                                                <?php foreach ($countries as $key => $country): ?>
                                                    <?php if ($key < 5): ?>
                                                        <li>
                                                            <a href="" data-value="<?= $country ?>"
                                                               class="link-hover js__changeCountry"><span><?= $country ?></span></a>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="cabinet__tab-item">
                                    <label for="field-city"
                                           class="cabinet__tab-label"><?= Yii::t('main', 'city') ?></label>
                                    <div class="cabinet__tab-field">
                                        <input type="text" class="field-input form-fields" name="city"
                                               i <?php if ($user->city): ?> value="<?= $user->city ?>" <?php endif; ?>
                                               placeholder="">
                                    </div>
                                </div>
                                <div class="cabinet__tab-item">
                                    <label for="field-address"
                                           class="cabinet__tab-label"><?= Yii::t('main', 'address') ?></label>
                                    <div class="cabinet__tab-field">
                                        <input type="text" class="field-input form-fields" name="address"
                                            <?php if ($user->address): ?> value="<?= $user->address ?>" <?php endif; ?>
                                               placeholder="">
                                    </div>
                                </div>
                                <div class="cabinet__tab-item">
                                    <label for="field-discount-card"
                                           class="cabinet__tab-label"><?= Yii::t('main', 'discount_card') ?></label>
                                    <div class="cabinet__tab-field">
                                        <input type="text" class="field-input form-fields" name="discount_card"
                                            <?php if ($user->discount_card): ?> value="<?= $user->discount_card ?>" <?php endif; ?>
                                               placeholder="">
                                    </div>
                                </div>
                                <div class="errorText"
                                     data-text="<?= Yii::t('main', 'fill_in_required_fields') ?>"><?= Yii::t('main', 'fill_in_required_fields') ?></div>
                                <div class="successText"></div>
                                <div class="cabinet__tab-action cabinet__tab-action--end cabinet__tab-action--margin">
                                    <a class="btn-border" href="<?= Url::to(['/account']) . '/' ?>">
                                        <span><?= Yii::t('main', 'abort') ?></span>
                                    </a>
                                    <button class="btn-border js__submitForm"
                                            onclick="formSend.send(this, event, 'update-info')">
                                        <span><?= Yii::t('main', 'save') ?></span></button>
                                </div>
                            </form>


                            <form action="<?= Url::to(['/account/ajax/update-password']) ?>" class="registr__tab-items">
                                <div class="cabinet__tab-item cabinet__tab-item--password">
                                    <label for="field-password-old"
                                           class="cabinet__tab-label"><?= Yii::t('main', 'old_password') ?>*</label>
                                    <div class="cabinet__tab-field">
                                        <input type="password" class="field-input form-fields required"
                                               name="old_password"
                                               value="" placeholder="">
                                    </div>
                                </div>
                                <div class="cabinet__tab-item">
                                    <label for="field-password-new"
                                           class="cabinet__tab-label"><?= Yii::t('main', 'new_password') ?>*</label>
                                    <div class="cabinet__tab-field">
                                        <input type="password" class="field-input form-fields required"
                                               name="new_password"
                                               value="" placeholder="">
                                    </div>
                                </div>
                                <div class="cabinet__tab-item">
                                    <label for="field-password-new-repeat"
                                           class="cabinet__tab-label"><?= Yii::t('main', 'confirm_password') ?>*</label>
                                    <div class="cabinet__tab-field">
                                        <input type="password" class="field-input form-fields required"
                                               name="confirm_password"
                                               value="" placeholder="">
                                    </div>
                                </div>
                                <div class="errorText"
                                     data-text="<?= Yii::t('main', 'fill_in_required_fields') ?>"><?= Yii::t('main', 'fill_in_required_fields') ?></div>
                                <div class="successText"></div>
                                <div class="cabinet__tab-action cabinet__tab-action--end cabinet__tab-action--margin">
                                    <button class="btn-border js__submitForm"
                                            onclick="formSend.send(this, event, 'update-password')">
                                        <span><?= Yii::t('main', 'save') ?></span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
