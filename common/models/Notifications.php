<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%notifications}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 * @property string $value
 * @property integer $created_at
 */
class Notifications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notifications}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'value', 'created_at'], 'required'],
            [['user_id', 'type', 'created_at'], 'integer'],
            [['value'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type' => 'Type',
            'value' => 'Value',
            'created_at' => 'Date',
        ];
    }

    public static function addMessage($user_id, $type, $slug, $params)
    {

        $notification = new Notifications();
        $notification->value = vsprintf(self::getMessage($slug), $params);
        $notification->user_id = $user_id;
        $notification->type = $type;
        $notification->created_at = time();
        $notification->save();

    }

    private static function getMessage($slug)
    {
        $messages = [
            'registration_user' => 'Регистрация нового пользователя: <a href="/manager/user/view?id=%s">%s</a>',
            'comment' => 'Новый комментарий ожидает модерации: <a href="/manager/comment/view?id=%s">коментарий от пользователя <span style="font-weight: bold; color: #177315">%s</span></a>',
            'write_us' => 'Форма Напиши Нам была отправлена на почту Администратора',
            'new_order' => 'Новый заказ: <a href="/manager/orders/view?id=%s">№%s</a> со статусом <b>«%s»</b>',
            'change_order_status' => 'Менеджер %s изменил статус заказа <a href="/manager/orders/view?id=%s">№%s</a> на <b>«%s»</b>',
        ];

        return $messages[$slug];
    }

    static function getCount()
    {
        $date = time() - (24 * 60 * 60);
        return self::find()->where(['>', 'created_at', $date])->count();
    }
}
