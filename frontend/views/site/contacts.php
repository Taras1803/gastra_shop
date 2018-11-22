<?php
?>

<section class="contacts">
    <div class="container">
        <div class="contacts__content">
            <div class="main-title">
                <h2><?= Yii::t('main', 'contacts') ?></h2>
            </div>
            <div class="contacts__inner contacts__inner--two">
                <div class="contacts__inline">
                    <ul>
                        <li>
                            <strong><?= Yii::t('main', 'phone') ?>:</strong>
                            <ul>
                                <li>
                                    <a href="tel:<?= str_replace(["(", ")", " ", "-"], "", $themeVariables['phone_1']) ?>" class="link-hover main-text main-text--md-lg"><span><?= $themeVariables['phone_1'] ?></span></a>
                                </li>
                                <li>
                                    <a href="tel:<?= str_replace(["(", ")", " ", "-"], "", $themeVariables['phone_2']) ?>" class="link-hover main-text main-text--md-lg"><span><?= $themeVariables['phone_2'] ?></span></a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <strong>E-mail:</strong>
                            <a href="mailto:<?= $themeVariables['company_email'] ?>" class="link-hover main-text main-text--md-lg"><span><?= $themeVariables['company_email'] ?></span></a>
                        </li>
                    </ul>
                </div>
                <div class="contacts__inline">
                    <ul>
                        <li>
                            <strong>Viber:</strong>
                            <a href="viber://chat?number=<?= str_replace(["(", ")", " ", "-"], "", $themeVariables['viber']) ?>" class="link-hover main-text main-text--md-lg"><span><?= $themeVariables['viber'] ?></span></a>
                        </li>
                        <li>
                            <strong>What’sApp:</strong>
                            <a href="whatsapp://send?phone=<?= str_replace(["(", ")", " ", "-"], "", $themeVariables['whats_app']) ?>" class="link-hover main-text main-text--md-lg"><span><?= $themeVariables['whats_app'] ?></span></a>
                        </li>
                        <li>
                            <strong>Telegram:</strong>
                            <a href="tg://resolve?domain=<?= str_replace(["(", ")", " ", "-"], "", $themeVariables['telegram']) ?>" class="link-hover main-text main-text--md-lg"><span><?= $themeVariables['telegram'] ?></span></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="contacts__inner contacts__inner--three contacts__inner--end">
                <div class="contacts__inline">
                    <strong><?= Yii::t('main', 'address_shops') ?>:</strong>
                    <?= $pageContent['contacts_address_1'] ?>
                </div>
                <div class="contacts__inline">
                    <?= $pageContent['contacts_address_2'] ?>
                </div>
                <div class="contacts__inline">
                    <?= $pageContent['contacts_address_3'] ?>
                </div>
            </div>
            <div class="contacts__bottom">
                <strong><?= Yii::t('main', 'write_to_us') ?>:</strong>
                <form action="/actions/write-us" class="contacts__form" enctype="multipart/form-data">
                    <div class="contacts__form-items">
                        <div class="contacts__form-item contacts__form-item--md">
                            <input type="text" class="field-input form-fields required"  name="name" placeholder="<?= Yii::t('main', 'first_name') ?>*">
                        </div>
                        <div class="contacts__form-item contacts__form-item--md">
                            <input type="text" class="field-input form-fields"  name="phone" placeholder="<?= Yii::t('main', 'phone') ?>">
                        </div>
                        <div class="contacts__form-item contacts__form-item--lg">
                            <input type="email" class="field-input form-fields required"  name="email" placeholder="E-mail*">
                        </div>
                        <div class="contacts__form-item contacts__form-item--lg">
                            <textarea name="comment" cols="30" rows="10" class="field-textarea form-fields required"  placeholder="<?= Yii::t('main', 'comment') ?>*"></textarea>
                        </div>
                        <div class="errorText" data-text="<?= Yii::t('main', 'fill_in_required_fields') ?>"><?= Yii::t('main', 'fill_in_required_fields') ?></div>
                        <div class="contacts__form-item contacts__form-item--sp-bw contacts__form-item--lg">
                            <div class="contacts__form-inline">
                                <div class="field-file link-hover">
                                    <label for="file-input" class="file-label"><?= Yii::t('main', 'attach_file') ?></label>
                                    <input type="file" name="" id="file-input" multiple>
                                </div>
                            </div>

                            <div class="successText"></div>
                            <div class="contacts__form-inline">
                                <button type="submit" class="btn-border btn-border--whith-arrow cf-arrow-right js__submitFor" onclick="formSend.send(this, event, 'write_us')"><span><?= Yii::t('main', 'send') ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>