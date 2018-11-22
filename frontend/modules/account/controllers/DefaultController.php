<?php

namespace frontend\modules\account\controllers;

use yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use common\models\Seo;
use frontend\modules\account\models\UserOrders;
use backend\models\ResetPasswordForm;

/**
 * Default controller for the `account` module
 */
class DefaultController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ]
        ];
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
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

    public function actionIndex()
    {
        $this->checkLogin();
        $user = Yii::$app->user->identity;
        $user_FIO = $user->last_name . " " . $user->first_name . " " . $user->middle_name;
        $metaData = Seo::getDataBySlug();
        $metaData['meta_title'] = Yii::t('main', 'account') . ' / ' . Yii::$app->params['site_name'];
        Yii::$app->params['metaData'] = $metaData;
        return $this->render('index', [
            'user' => $user,
            'user_fio' => $user_FIO,
        ]);
    }

    /**
     * @return string
     */
    public function actionOrders()
    {
        $this->checkLogin();
        $metaData = Seo::getDataBySlug();
        $metaData['meta_title'] = Yii::t('main', 'orders_history') . ' / ' . Yii::t('main', 'account') . ' / ' . Yii::$app->params['site_name'];
        Yii::$app->params['metaData'] = $metaData;

        return $this->render('orders', [
            'orders_data' => UserOrders::getUserOrders()
        ]);
    }

    public function actionEdit()
    {
        $this->checkLogin();
        $user = Yii::$app->user->identity;

        $metaData = Seo::getDataBySlug();
        $metaData['meta_title'] = Yii::t('main', 'edit') . ' / ' . Yii::t('main', 'account') . ' / ' . Yii::$app->params['site_name'];
        Yii::$app->params['metaData'] = $metaData;

        return $this->render('edit', [
            'user' => $user,
        ]);
    }

    /**
     * Displays login page.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest)
            return $this->redirect(Url::to(['/account']) . '/');

        $metaData = Seo::getDataBySlug('/account/login');
        Yii::$app->params['metaData'] = $metaData;
        return $this->render('login');
    }


    /**
     * Displays registration page.
     *
     * @return mixed
     */
    public function actionRegistration()
    {
        if (!Yii::$app->user->isGuest)
            return $this->redirect(Url::to(['/account']) . '/');

        $metaData = Seo::getDataBySlug('/account/registration');
        Yii::$app->params['metaData'] = $metaData;
        return $this->render('registration');
    }

    public function actionForgot()
    {
        if (!Yii::$app->user->isGuest)
            return $this->redirect(Url::to(['/account']) . '/');

        $metaData = Seo::getDataBySlug('/account/forgot');
        Yii::$app->params['metaData'] = $metaData;
        return $this->render('forgot');
    }

    private function checkLogin()
    {
        if (Yii::$app->user->isGuest)
            return $this->redirect(Url::to(['/account/login']));
    }

}
