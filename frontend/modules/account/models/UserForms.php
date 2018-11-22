<?php

namespace frontend\modules\account\models;

use common\models\UserBasket;
use frontend\components\BasketHelper;
use Yii;
use common\models\Lang;
use common\models\Notifications;
use common\models\User;
use yii\helpers\Url;

class UserForms
{
    static function signUp($data)
    {
        $json = [];
        $json['error'] = 0;
        $json['text'] = Yii::t('main', 'form_registration_success');
        $json['action'] = 'show_text_reload';
        if ($data['password'] != $data['repeat_password']) {
            $json['error'] = 1;
            $json['text'] = Yii::t('main', 'error_repeated_password');
            return $json;
        }

        if (User::find()->where(['email' => $data['email']])->count() > 0) {
            $json['error'] = 1;
            $json['text'] = Yii::t('main', 'error_user_already_exist');
            return $json;
        }

        $lang = Lang::getCurrent();
        $user = new User();
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->middle_name = $data['middle_name'];
        $user->phone = $data['phone'];
        $user->dob = $data['dob'];
        $user->country = $data['country'];
        $user->city = $data['city'];
        $user->address = $data['address'];
        $user->email = $data['email'];
        $user->lang = $lang->id;
        $user->setPassword($data['password']);
        $user->generateAuthKey();

        if ($user->save()) {
            $ub = new UserBasket();
            $ub->user_id = $user->id;
            $ub->save();
            Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'frontend/registration-html'],
                    ['user' => [
                        'name' => $data['first_name'],
                        'email' => $user->email,
                        'password' => $data['password'],
                    ]]
                )
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->params['site_name']])
                ->setTo($data['email'])
                ->setSubject(Yii::t('mail', 'registration_on') . ' ' . Yii::$app->params['site_name'])
                ->send();
            Yii::$app->user->login($user, 3600);
            Notifications::addMessage($user->id, 1, 'registration_user', [$user->id, $user->first_name]);
            return $json;
        } else {
            $json['error'] = 1;
            $json['text'] = Yii::t('main', 'error_form_send');
            return $json;
        }
    }

    public static function login($data)
    {
        $json = [];
        $json['error'] = 0;
        $json['text'] = '';
        $json['action'] = 'go_to';
        $json['location'] = Url::to(['/account']) . '/';

        $user = User::find()->where(['email' => $data['email'], 'status' => 10])->one();

        if (!$user || !$user->validatePassword($data['password'])) {
            $json['error'] = 1;
            $json['text'] = Yii::t('main', 'incorrect_login_password');
            return $json;
        }

        if(!UserBasket::findOne(['user_id' => $user->id])){
            $ub = new UserBasket();
            $ub->user_id = $user->id;
            $ub->save();
        }
        $gb = BasketHelper::getUserBasket();
        if($gb){
            $ub = UserBasket::findOne(['user_id' => $user->id]);
            $basket_data = [];
            if($ub)
                $basket_data = json_decode($ub->params, true);
            foreach ($gb as $product){
                $basket_data[] = $product;
            }

            $ub->params = json_encode($basket_data);
            $ub->save();
            Yii::$app->session->remove('userBasket');
        }


        Yii::$app->user->login($user, 3600);

        return $json;
    }

    public static function forgotSendEmail($email)
    {
        $json = [];
        $json['error'] = 0;
        $json['text'] = Yii::t('main', 'form_forgot_success');
        $json['action'] = 'show_text';

        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $email,
        ]);

        if (!$user) {
            $json['error'] = 1;
            $json['text'] = Yii::t('main', 'email_not_exists');
            return $json;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                $json['error'] = 1;
                $json['text'] = Yii::t('main', 'error_form_send');
                return $json;
            }
        }

        $pass = rand(100000, 999999);

        Yii::$app
            ->mailer
            ->compose(
                ['html' => 'frontend/forgot-html'],
                ['data' => [
                    'user_name' => $user->first_name . ' ' . $user->last_name,
                    'pass' => $pass,
                    'link' => Url::to(['/account/ajax/forgot-password', 'token' => $user->password_reset_token, 'password' => $pass]),
                ]]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->params['site_name']])
            ->setTo($email)
            ->setSubject(Yii::t('mail', 'reset_password') . ' ' . Yii::$app->params['site_name'])
            ->send();

        return $json;
    }

    public static function resetPassword($pass, $token)
    {
        if (empty($token) || !is_string($token))
            return false;
        $user = User::findByPasswordResetToken($token);
        if (!$user)
            return false;
        if (strlen($pass) < 5)
            return false;

        $user->setPassword($pass);
        $user->removePasswordResetToken();

        return $user->save(false);
    }

    public static function updateInfo($data)
    {
        $json = [];
        $json['error'] = 0;
        $json['text'] = Yii::t('main', 'form_update_info_success');
        $json['action'] = 'show_text_reload';
        $user = Yii::$app->user->identity;
        if (User::find()->where(['email' => $data['email']])->andWhere(['!=', 'id', $user->id])->count()) {
            $json['error'] = 0;
            $json['text'] = Yii::t('main', 'error_user_already_exist');
            return $json;
        }
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->middle_name = $data['middle_name'];
        $user->phone = $data['phone'];
        $user->dob = $data['dob'];
        $user->country = $data['country'];
        $user->city = $data['city'];
        $user->address = $data['address'];
        $user->email = $data['email'];
        $user->organization = $data['organization'];
        $user->discount_card = $data['discount_card'];
        $user->updated_at = time();

        if ($user->save()) {
            return $json;
        } else {
            $json['error'] = 1;
            $json['text'] = Yii::t('main', 'error_form_send');
            return $json;
        }
    }

    public static function updatePassword($data)
    {
        $json = [];
        $json['error'] = 0;
        $json['text'] = Yii::t('main', 'form_update_password_success');
        $json['action'] = 'show_text_reload';
        $user = Yii::$app->user->identity;
        if (!$user->validatePassword($data['old_password'])) {
            $json['error'] = 1;
            $json['text'] = Yii::t('main', 'incorrect_password');
            return $json;
        } elseif ($data['new_password'] != $data['confirm_password']) {
            $json['error'] = 1;
            $json['text'] = Yii::t('main', 'error_repeated_password_edit');
            return $json;
        } else {
            $user->setPassword($data['new_password']);
            if ($user->save()) {
                return $json;
            } else {
                $json['error'] = 1;
                $json['text'] = Yii::t('main', 'error_form_send');
                return $json;
            }
        }


    }
}