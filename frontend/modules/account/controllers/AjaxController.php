<?php

namespace frontend\modules\account\controllers;

use yii;
use yii\web\Controller;
use frontend\modules\account\models\UserForms;
use yii\helpers\Url;

/**
 * Ajax controller for the `account` module
 */
class AjaxController extends Controller
{

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignUp()
    {
        $post = Yii::$app->request->post();
        if (!Yii::$app->user->isGuest)
            return $this->goHome();

        $json = UserForms::signUp($post);
        return $this->asJson($json);
    }

    public function actionUpdateInfo()
    {
        $post = Yii::$app->request->post();

        if (Yii::$app->user->isGuest || !$post) {
            return $this->goHome();
        }

        $json = UserForms::updateInfo($post);
        return $this->asJson($json);
    }

    public function actionUpdatePassword()
    {
        $post = Yii::$app->request->post();

        if (Yii::$app->user->isGuest || count($post) < 3) {
            return $this->goHome();
        }
        $json = UserForms::updatePassword($post);
        return $this->asJson($json);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $post = Yii::$app->request->post();
        if (!Yii::$app->user->isGuest || count($post) < 2){

            return $this->goHome();
        }

        $json = UserForms::login($post);
        return $this->asJson($json);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionForgotPassword()
    {
        $pass = Yii::$app->request->get('password', false);
        $token = Yii::$app->request->get('token', false);
        if ($pass && $token) {
            if (UserForms::resetPassword($pass, $token)) {
                return $this->redirect(Url::to(['/account/login', 'password' => 'changed']));
            } else
                return $this->goHome();

        } else {
            $data = Yii::$app->request->post();

            if (!$data['email']) {
                return $this->goHome();
            }


            $json = UserForms::forgotSendEmail($data['email']);
            return $this->asJson($json);
        }
    }

}