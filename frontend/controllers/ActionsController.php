<?php

namespace frontend\controllers;

use common\models\Currency;
use common\models\PromoCodes;
use common\models\UserWishlist;
use frontend\components\BasketHelper;
use frontend\components\CheckoutHelper;
use frontend\components\PaymentHelper;
use frontend\components\ThemeHelper;
use Yii;
use yii\web\Controller;
use common\models\CurrentTime;
use common\models\Comment;

/**
 * Actions controller
 */
class ActionsController extends Controller
{

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionPaypalListener()
    {
        try {
            if (!PaymentHelper::paypalListener())
                return $this->goHome();
        } catch (\Exception $e) {
            return $this->goHome();
        }
    }

    public function actionLiqpayListener()
    {
        try {
            if (!PaymentHelper::liqpayListener())
                return $this->goHome();
        } catch (\Exception $e) {
            return $this->goHome();
        }
    }


    public function actionSetUserOffsetTime()
    {
        $data = Yii::$app->request->post();
        if ($data['dtz']) {
            CurrentTime::setUserOffsetTime($data);
        }
    }

    public function actionLogout()
    {
        $post = Yii::$app->request->post();
        if ($post && isset($post['logout'])) {
            Yii::$app->user->logout();
        } else
            $this->goHome();
    }

    public function actionWriteUs()
    {
        $post = Yii::$app->request->post('fields', []);
        if ($post) {
            $json = ThemeHelper::sendWriteUsForm($post);
            return $this->asJson($json);
        } else
            return $this->goHome();
    }

    public function actionSetCurrency()
    {
        $currency_id = Yii::$app->request->post('id', false);
        if ($currency_id) {
            Currency::setCurrent($currency_id);
        } else
            return $this->goHome();
    }

    public function actionProductsToWishlist()
    {
        $post = Yii::$app->request->post();
        if ($post) {
            if ($post['action'] == 'add') {
                $json = UserWishlist::addProduct($post['product_id']);
                return $this->asJson($json);
            } elseif ($post['action'] == 'remove') {
                $json = UserWishlist::removeProduct($post['product_id']);
                return $this->asJson($json);
            }
        } else
            return $this->goHome();
    }

    public function actionAddProductToBasket()
    {
        $post = Yii::$app->request->post();
        if ($post) {
            $json = BasketHelper::addProduct($post);
            return $this->asJson($json);
        } else
            return $this->goHome();
    }

    public function actionRemoveProductFromBasket()
    {
        $post = Yii::$app->request->post();
        if ($post) {
            $json = BasketHelper::removeProduct($post['key']);
            return $this->asJson($json);
        } else
            return $this->goHome();
    }

    public function actionChangeProductCount()
    {
        $post = Yii::$app->request->post();
        if ($post) {
            $json = BasketHelper::changeProductCount($post);
            return $this->asJson($json);
        } else
            return $this->goHome();
    }

    public function actionSaveCheckoutData()
    {
        $post = Yii::$app->request->post();
        if ($post) {
            $json = CheckoutHelper::saveInformation($post);
            return $this->asJson($json);
        } else
            return $this->goHome();
    }

    public function actionCheckPromoCode()
    {
        $post = Yii::$app->request->post();
        if ($post) {
            $json = PromoCodes::check($post['promoCode']);
            return $this->asJson($json);
        } else
            return $this->goHome();
    }
}
