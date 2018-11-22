<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%orders}}".
 *
 * @property int $id
 * @property int $session_id
 * @property int $user_id
 * @property string $user_name
 * @property string $phone
 * @property string $email
 * @property string $delivery_method
 * @property string $payment_method
 * @property string $total_price
 * @property int $status_id
 * @property int $created_at
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%orders}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['session_id', 'user_name', 'email', 'delivery_method', 'payment_method', 'total_price', 'status_id', 'created_at'], 'required'],
            [['session_id', 'user_id', 'status_id', 'created_at'], 'integer'],
            [['total_price'], 'number'],
            [['user_name'], 'string', 'max' => 255],
            [['phone', 'email', 'delivery_method', 'payment_method'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'session_id' => 'Session ID',
            'user_id' => 'User ID',
            'user_name' => 'ФИО',
            'phone' => 'Телефон',
            'email' => 'Email',
            'delivery_method' => 'Способ Доставки',
            'payment_method' => 'Способ Оплаты',
            'total_price' => 'Сумма Заказа',
            'status_id' => 'Статус',
            'created_at' => 'Дата',
        ];
    }
}
