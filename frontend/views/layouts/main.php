<?php

/* @var $this \yii\web\View */

/* @var $content string */

use common\models\Countries;
use common\models\CurrentTime;
use yii\helpers\Html;
use frontend\assets\AppAsset;
use frontend\widgets\Menu;
use frontend\widgets\Footer;
use yii\helpers\Url;

AppAsset::register($this);
$countries = Countries::getCountries();
?>


<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="initial-scale=1.0, width=device-width">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(Yii::$app->params['metaData']['meta_title']) ?></title>

    <?= Html::csrfMetaTags() ?>

    <meta name="author" content="<?= Yii::$app->params['author'] ?>"/>
    <meta name="description" content="<?= Yii::$app->params['metaData']['meta_description'] ?>"/>


    <meta property="og:site_name" content="<?= Yii::$app->params['author'] ?>"/>
    <meta property="og:title" content="<?= Yii::$app->params['metaData']['meta_title'] ?>"/>
    <meta property="og:type" content="website"/>
    <meta property="og:description" content="<?= Yii::$app->params['metaData']['meta_description'] ?>"/>
    <meta property="og:url" content="<?= Yii::$app->params['metaData']['url'] ?>"/>
    <meta property="og:image" content="<?= Yii::$app->params['metaData']['meta_img'] ?>"/>

    <meta name="twitter:site" content="<?= Yii::$app->params['author'] ?>"/>
    <meta name="twitter:title" content="<?= Yii::$app->params['metaData']['meta_title'] ?>">
    <meta name="twitter:description" content="<?= Yii::$app->params['metaData']['meta_description'] ?>"/>
    <meta name="twitter:image" content="<?= Yii::$app->params['metaData']['meta_img'] ?>"/>
    <meta name="twitter:creator" content="<?= Yii::$app->params['author'] ?>"/>

    <link rel="canonical" href="<?= Yii::$app->params['metaData']['url'] ?>"/>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <?php $this->head() ?>

</head>

<body data-userTime="<?= CurrentTime::getUserTimeSession() ?>">
<?php $this->beginBody() ?>
<main class="main">
    <?= Menu::widget() ?>

    <?= $content ?>

    <?= Footer::widget() ?>
</main>

<div class="overlay"></div>
<div class="modal modal--sign-in">
    <div class="modal__close cf-cancel"></div>
    <div class="modal__tabs">
        <div class="modal__tabs-buttons">
            <button class="modal__tabs-button is-active  link-hover" data-open="tab-login">
                <span><?= Yii::t('main', 'login') ?></span>
            </button>
            <button class="modal__tabs-button link-hover" data-open="tab-registration">
                <span><?= Yii::t('main', 'registration') ?></span>
            </button>
        </div>
        <div class="modal__contents">
            <div class="modal__content tab-registration">
                <form action="<?= Url::to(['/account/ajax/sign-up']) ?>" class="modal__form">
                    <div class="modal__items">
                        <div class="modal__item">
                            <label for="field-email" class="field-label">E-mail*</label>
                            <input type="email" class="field-input form-fields required" name="email" id="field-email">
                        </div>
                        <div class="modal__item">
                            <label for="field-password" class="field-label"><?= Yii::t('main', 'password') ?>*</label>
                            <input type="password" class="field-input form-fields required" name="password"
                                   id="field-password">
                        </div>
                        <div class="modal__item">
                            <label for="field-repeat--password"
                                   class="field-label"><?= Yii::t('main', 'repeat_password') ?>*</label>
                            <input type="password" class="field-input form-fields required" name="repeat_password"
                                   id="field-repeat--password">
                        </div>
                    </div>
                    <div class="modal__items">
                        <div class="modal__item">
                            <label for="field-surname" class="field-label"><?= Yii::t('main', 'last_name') ?>*</label>
                            <input type="text" class="field-input form-fields required" name="last_name">
                        </div>
                        <div class="modal__item">
                            <label for="field-name" class="field-label"><?= Yii::t('main', 'first_name') ?>*</label>
                            <input type="text" class="field-input form-fields required" name="first_name"
                                   id="field-name">
                        </div>
                        <div class="modal__item">
                            <label for="field-name-father"
                                   class="field-label"><?= Yii::t('main', 'middle_name') ?></label>
                            <input type="text" class="field-input" id="field-name-father" name="" placeholder="">
                        </div>
                        <div class="modal__item">
                            <label for="field-phone" class="field-label"><?= Yii::t('main', 'phone') ?></label>
                            <input type="text" class="field-input form-fields" name="phone" id="field-tel"
                                   placeholder="+38">
                        </div>
                        <div class="modal__item">
                            <label for="field-burn" class="field-label"><?= Yii::t('main', 'dob') ?></label>
                            <input type="date" class="field-input unstyled form-fields" name="dob" id="field-born"
                                   placeholder="00.00.0000">
                        </div>

                        <div class="modal__item js__customDropDown">
                            <label for="field-country" class="field-label"><?= Yii::t('main', 'country') ?></label>
                            <div class="dropdown-main dropdown-main--select js__customDropDown">
                                <div class="dropdown-main__header dropdown-main__header--js-click">
                                    <input  type="text" class="field-input form-fields js_input_field"
                                           name="country"
                                           value="<?= $countries[1] ?>">
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


                        <div class="modal__item">
                            <label for="field-city" class="field-label"><?= Yii::t('main', 'city') ?></label>
                            <input type="text" class="field-input form-fields" name="city" id="field-city">
                        </div>
                        <div class="modal__item">
                            <label for="field-address" class="field-label"><?= Yii::t('main', 'address') ?></label>
                            <input type="text" class="field-input form-fields" name="address" id="field-adresse">
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
            <div class="modal__content tab-login is-active">
                <form action="<?= Url::to(['/account/ajax/login']) ?>" class="modal__form">
                    <div class="modal__items">
                        <div class="modal__item">
                            <label for="field-email2" class="field-label">E-mail*</label>
                            <input type="email" class="field-input form-fields required" name="email" id="field-email2">
                        </div>
                        <div class="modal__item">
                            <label for="field-password2" class="field-label"><?= Yii::t('main', 'password') ?>*</label>
                            <input type="password" class="field-input form-fields required" name="password"
                                   id="field-password2">
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

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
