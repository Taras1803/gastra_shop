<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\Products;
use common\models\News;
use common\models\PagesContent;
use common\models\Seo;
use common\models\ThemeVariables;
use frontend\components\BasketHelper;
use common\models\PromoCodes;
use frontend\components\CheckoutHelper;
use frontend\components\PaymentHelper;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $metaData = Seo::getDataBySlug('/');
        Yii::$app->params['metaData'] = $metaData;
        return $this->render('index', [
            'about_image' => ThemeVariables::getValueBySlug('home_about_img'),
            'about_text' => PagesContent::getPagesContentBySlug('home_about_us_text'),
            'news' => News::find()->where(['status' => 1])->orderBy(['created_at' => SORT_DESC])->limit(3)->all(),
            'action_products' => Products::find()->where(['status' => 1])->andWhere(['>', 'action', 0])->orderBy(['updated_at' => SORT_DESC])->limit(8)->all(),
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionAboutUs()
    {
        $themeVariables = ThemeVariables::getValues();
        $metaData = Seo::getDataBySlug('/about-us');
        $metaData['meta_img'] = Yii::$app->glide->createSignedUrl([
            'glide/index',
            'path' => 'images/' . $themeVariables['about_page_top_image'],
            'w' => 950
        ], true);
        Yii::$app->params['metaData'] = $metaData;

        return $this->render('about-us', [
            'themeVariables' => $themeVariables,
            'pageContent' => PagesContent::getPagesContents(),
        ]);
    }
    public function actionPaymentDelivery()
    {
        $metaData = Seo::getDataBySlug('/payment-delivery');
        Yii::$app->params['metaData'] = $metaData;

        return $this->render('payment-delivery', [
            'pageContent' => PagesContent::getPagesContents(),
        ]);
    }
    public function actionContacts()
    {
        $metaData = Seo::getDataBySlug('/contacts');
        Yii::$app->params['metaData'] = $metaData;
        return $this->render('contacts', [
            'themeVariables' => ThemeVariables::getValues(),
            'pageContent' => PagesContent::getPagesContents(),
        ]);
    }
    public function actionShoppingCart()
    {
        $metaData = Seo::getDataBySlug('/shopping-cart');
        Yii::$app->params['metaData'] = $metaData;

        return $this->render('shopping-cart', [
            'data' => BasketHelper::getBasketData()
        ]);
    }
    public function actionCheckout()
    {
        $data = CheckoutHelper::getCheckoutData();
        if(!$data)
            return $this->redirect(Url::to(['/shopping-cart']));

        $metaData = Seo::getDataBySlug('/checkout');
        Yii::$app->params['metaData'] = $metaData;


        return $this->render('checkout', [
            'data' => $data
        ]);
    }

    public function actionSuccessful($status)
    {
        if($status != 'completed')
            throw new NotFoundHttpException();

        $post = Yii::$app->request->post('checkoutData', false);
        if($post){
            PaymentHelper::prepareFormData($post);
        }

        $metaData = Seo::getDataBySlug('/successful');
        Yii::$app->params['metaData'] = $metaData;

        BasketHelper::clearUserBasket();
        PromoCodes::clearCurrent();

        return $this->render('successful', [
            'successful_text' => PagesContent::getPagesContentBySlug('successful_text'),
        ]);
    }
}
