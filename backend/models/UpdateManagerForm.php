<?php

namespace backend\models;

use Yii;
use yii\base\Model;


class UpdateManagerForm extends Model
{
    public $id = 0;
    public $username;
    public $email;
    public $phone;
    public $password = '';
    public $avatar = 'avatar.png';
    public $role = 2;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'email', 'phone', 'password', 'role'], 'required'],
            [['username', 'avatar'], 'string', 'min' => 2, 'max' => 255],
            ['email', 'email', 'message' => 'Некорректный email'],
            ['password', 'string', 'min' => 6],
        ];
    }


    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function saveManager()
    {
        if($this->id == 0 && Manager::find()->where(['email' => $this->email])->one())
        {
            $this->addError('email', 'Менеджер с таким Email уже существует');
            return false;
        }
        if($this->id == 0){
            $user = new Manager();
            $user->status = 10;
            $user->created_at = time();
            $user->generateAuthKey();
        }else{
            if($this->id == 1)
                return false;
            $user = Manager::findOne($this->id);
        }
        $user->username = $this->username;
        $user->phone = $this->phone;
        $user->email = $this->email;
        $user->role = $this->role;
        $user->setPassword($this->password);
        $user->updated_at = time();
        if($user->save()){
            Yii::$app->session->setFlash('success', 'Данные успешно сохранены!');
            return true;
        }else
            return false;
    }

    public function loadData($id)
    {
        if($id == 1)
            return false;
        $user = Manager::findOne($id);
        if(!$user)
            return false;
        $this->id = $id;
        $this->username = $user->username;
        $this->phone = $user->phone;
        $this->email = $user->email;
        $this->avatar = $user->avatar;
        $this->role = $user->role;
        return true;
    }

}
