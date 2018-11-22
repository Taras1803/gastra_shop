<?php

namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * UpdateProfileForm model
 *
 * @property integer $username
 * @property string $email
 * @property string $avatar
 * @property string $phone

 */


class UpdateProfileForm extends Model
{
    public  $username = '';
    public  $email = '';
    public  $phone = '';
    public  $avatar = 'avatar.png';
    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'email', 'avatar', 'phone'], 'required'],
            ['email', 'email', 'message' => 'Email is not valid'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя',
            'email' => 'Email',
            'avatar' => 'Фото',
            'phone' => 'Телефон',
        ];
    }


    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function updateProfile()
    {
        $user = $this->getUser();
        if($user->email != $this->email){
            if(Manager::find()->where(['email' => $this->email])->one()){
                Yii::$app->session->setFlash('error', 'Duplicate of emails! Enter another email address.');
                return false;
            }
        }
        $user->username = $this->username;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->avatar = $this->avatar;
        $user->updated_at = time();
        if($user->save()){
            Yii::$app->user->setIdentity($user);
            Yii::$app->session->setFlash('success', 'Data saved successfully!');
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return Manager|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Manager::findOne(Yii::$app->user->id);
        }

        return $this->_user;
    }
}
