<?php
?>

<section class="cabinet">
    <div class="container">
        <div class="cabinet__content">
            <div class="main-title">
                <h2><?= Yii::t('main', 'checkout') ?></h2>
                <div class="white-layer">
                    <p>
                        <span><strong><?= Yii::t('main', 'products_count') ?>:</strong> <?= $data['products_count'] ?> <?= Yii::t('main', 'pc') ?></span>
                        <span><strong><?= Yii::t('main', 'sum') ?>:</strong> <?= $data['totals']['sub_total']['price'] ?> <?= $data['currency']['symbol'] ?></span>
                        <?php if(isset($data['totals']['promo_code'])): ?>
                            <span><strong><?= Yii::t('main', 'discount') ?>:</strong> <?= $data['totals']['promo_code']['title'] ?></span>
                        <?php endif; ?>
                        <span><strong><?= Yii::t('main', 'total') ?>:</strong> <?= $data['totals']['total']['price'] ?> <?= $data['currency']['symbol'] ?></span>
                    </p>
                </div>
            </div>
            <div class="cabinet__body">
                <div class="cabinet__tabs">
                    <div class="cabinet__tab tab-personal-data is-active">
                        <form class="cabinet__tab-items" action="/actions/save-checkout-data">
                            <div class="cabinet__tab-item">
                                <div class="cabinet__tab-title"><?= Yii::t('main', 'main_info') ?>:</div>
                            </div>
                            <div class="cabinet__tab-item">
                                <label for="field-f" class="cabinet__tab-label"><?= Yii::t('main', 'last_name') ?>*</label>
                                <div class="cabinet__tab-field">
                                    <input type="text" class="field-input form-fields required" name="last_name" id="field-f" value="<?= $data['information']['last_name'] ?>">
                                </div>
                            </div>
                            <div class="cabinet__tab-item">
                                <label for="checkout_field-name" class="cabinet__tab-label"><?= Yii::t('main', 'first_name') ?>*</label>
                                <div class="cabinet__tab-field">
                                    <input type="text" class="field-input form-fields required" name="first_name" id="checkout_field-name" value="<?= $data['information']['first_name'] ?>">
                                </div>
                            </div>
                            <div class="cabinet__tab-item">
                                <label for="checkout_field-fath" class="cabinet__tab-label"><?= Yii::t('main', 'middle_name') ?></label>
                                <div class="cabinet__tab-field">
                                    <input type="text" class="field-input form-fields" name="middle_name" id="checkout_field-fath" value="<?= $data['information']['middle_name'] ?>">
                                </div>
                            </div>
                            <div class="cabinet__tab-item">
                                <label for="checkout_field-email" class="cabinet__tab-label">Email*</label>
                                <div class="cabinet__tab-field">
                                    <input type="email" class="field-input form-fields required" name="email" id="checkout_field-email" value="<?= $data['information']['email'] ?>">
                                </div>
                            </div>
                            <div class="cabinet__tab-item">
                                <label for="field-phone" class="cabinet__tab-label"><?= Yii::t('main', 'phone') ?></label>
                                <div class="cabinet__tab-field">
                                    <input type="text" class="field-input form-fields" name="phone" id="field-phone" value="<?= $data['information']['phone'] ?>">
                                </div>
                            </div>
                            <div class="cabinet__tab-item">
                                <div class="cabinet__tab-title"><?= Yii::t('main', 'delivery') ?></div>
                            </div>
                            <div class="cabinet__tab-item">
                                <label for="checkout_field-delivery" class="cabinet__tab-label"><?= Yii::t('main', 'delivery_method') ?>*</label>
                                <div class="cabinet__tab-field">
                                    <div class="dropdown-main dropdown-main--select js__customDropDown">
                                        <div class="dropdown-main__header dropdown-main__header--js-click">
                                            <p><?= $data['delivery_methods'][$data['information']['delivery_method']]['title'] ?></p>
                                            <input type="hidden" class="form-fields required " id="checkout_field-delivery" value="<?= $data['information']['delivery_method'] ?>" name="delivery_method">
                                            <span class="cf-arrow-down"></span>
                                        </div>
                                        <ul class="dropdown-main__body">
                                            <?php foreach ($data['delivery_methods'] as $key => $delivery_methods): ?>
                                                <li>
                                                    <a href="#" data-value="<?= $key ?>" data-text="<?= $delivery_methods['description'] ?>" data-p_text="<?= $delivery_methods['title'] ?>" class="link-hover js__changeDeliveryMethod"><span><?= $delivery_methods['title'] ?></span></a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="cabinet__tab-item js__deliveryAddressContainer" style="<?= ($data['information']['delivery_method'] != 'pickup') ? '' : 'display: none;' ?>">
                                <div class="cabinet__tab-title"><?= Yii::t('main', 'delivery_address') ?></div>
                            </div>
                            <div class="cabinet__tab-item" style="<?= ($data['information']['delivery_method'] != 'pickup') ? '' : 'display: none;' ?>">
                                <label for="checkout_field-country" class="cabinet__tab-label"><?= Yii::t('main', 'country') ?>*</label>
                                <div class="cabinet__tab-field">
                                    <div class="dropdown-main dropdown-main--select js__customDropDown">
                                        <div class="dropdown-main__header dropdown-main__header--js-click">
                                            <p><?= ($data['information']['country'])? $data['information']['country'] : $data['countries'][1] ?></p>
                                            <input type="hidden" class="js__deliveryField <?= ($data['information']['delivery_method'] != 'pickup') ? 'form-fields required' : '' ?>" id="checkout_field-country" value="<?= ($data['information']['country'])? $data['information']['country'] : $data['countries'][1] ?>" name="country">
                                            <span class="cf-arrow-down"></span>
                                        </div>
                                        <ul class="dropdown-main__body">
                                            <?php foreach($data['countries'] as $key => $country): ?>
                                            <?php if($key < 5): ?>
                                                    <li>
                                                        <a href="#" data-value="<?= $country ?>" class="link-hover js__changeCheckoutCountry"><span><?= $country ?></span></a>
                                                    </li>
                                            <?php endif; ?>

                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="cabinet__tab-item" style="<?= ($data['information']['delivery_method'] != 'pickup') ? '' : 'display: none;' ?>">
                                <label for="checkout_field-city" class="cabinet__tab-label"><?= Yii::t('main', 'city') ?>*</label>
                                <div class="cabinet__tab-field">
                                    <input type="text" class="field-input js__deliveryField <?= ($data['information']['delivery_method'] != 'pickup') ? 'form-fields required' : '' ?>" name="city" id="checkout_field-city" value="<?= $data['information']['city'] ?>">
                                </div>
                            </div>
                            <div class="cabinet__tab-item" style="<?= ($data['information']['delivery_method'] == 'nova_poshta_courier') ? '' : 'display: none;' ?>">
                                <label for="checkout_field-address" class="cabinet__tab-label"><?= Yii::t('main', 'address') ?>*</label>
                                <div class="cabinet__tab-field">
                                    <input type="text" class="field-input js__deliveryField <?= ($data['information']['delivery_method'] == 'nova_poshta_courier') ? 'form-fields required' : '' ?>" name="address" id="checkout_field-address" value="<?= $data['information']['address'] ?>">
                                </div>
                            </div>

                            <div class="cabinet__tab-item" style="<?= ($data['information']['delivery_method'] == 'nova_poshta') ? '' : 'display: none;' ?>">
                                <label for="checkout_field-np_detachment" class="cabinet__tab-label"><?= Yii::t('main', 'np_detachment') ?>*</label>
                                <div class="cabinet__tab-field">
                                    <input type="text" class="field-input js__deliveryField <?= ($data['information']['delivery_method'] == 'nova_poshta') ? 'form-fields required' : '' ?>" name="np_detachment" id="checkout_field-np_detachment" value="<?= $data['information']['np_detachment'] ?>">
                                </div>
                            </div>

                            <p class="js__deliveryText"><?= $data['delivery_methods'][$data['information']['delivery_method']]['description'] ?></p>

                            <div class="cabinet__tab-item">
                                <div class="cabinet__tab-title"><?= Yii::t('main', 'payment') ?></div>
                            </div>
                            <div class="cabinet__tab-item">
                                <label for="" class="cabinet__tab-label"><?= Yii::t('main', 'payment_method') ?>*</label>
                                <div class="cabinet__tab-field">
                                    <div class="dropdown-main dropdown-main--select js__customDropDown">
                                        <div class="dropdown-main__header dropdown-main__header--js-click">
                                            <p id="field-payment-p"><?= $data['payment_methods'][$data['information']['payment_method']]['name'] ?></p>
                                            <input type="hidden" class="form-fields required " id="field-payment" value="<?= $data['information']['payment_method'] ?>" name="payment_method">
                                            <span class="cf-arrow-down"></span>
                                        </div>
                                        <ul class="dropdown-main__body">
                                            <?php foreach ($data['payment_methods'] as $key => $payment_methods): ?>
                                                <li style="<?= ($data['information']['delivery_method'] == 'pickup' && $key == 'cod') ? 'display: none;' : '' ?>">
                                                    <a href="#" data-value="<?= $key ?>" data-text="<?= $payment_methods['name'] ?>" class="link-hover js__changePaymentMethod"><span><?= $payment_methods['name'] ?></span></a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="cabinet__tab-item">
                                <textarea name="comment" class="field-textarea form-fields" placeholder="<?= Yii::t('main', 'order_comment') ?>" cols="30" rows="10"><?= $data['information']['comment'] ?></textarea>
                            </div>
                            <div class="errorText"
                                 data-text="<?= Yii::t('main', 'fill_in_required_fields') ?>"><?= Yii::t('main', 'fill_in_required_fields') ?></div>
                            <div class="successText"></div>
                            <div class="cabinet__tab-action cabinet__tab-action--end cabinet__tab-action--margin">
                                <button type="submit" class="btn-yellow btn-border--whith-arrow cf-arrow-right js__submitForm" onclick="formSend.send(this, event, 'checkout')"><?= Yii::t('main', 'checkout_button') ?></button>
                            </div>
                        </form>
                        <div style="display: none;" id="js__formContainer">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $this->registerJsFile('/js/checkout.js', ['depends'=>'frontend\assets\AppAsset']); ?>