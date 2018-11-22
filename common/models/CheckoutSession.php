<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%checkout_session}}".
 *
 * @property int $id
 * @property string $lang
 * @property int $time_offset
 * @property string $user_id
 * @property int $order_id
 * @property string $user_basket
 * @property string $information
 * @property string $payment_information
 * @property string $totals
 * @property int $status
 * @property int $created_at
 */
class CheckoutSession extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%checkout_session}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'totals', 'created_at'], 'required'],
            [['order_id', 'status', 'created_at', 'time_offset'], 'integer'],
            [['user_basket', 'information', 'payment_information', 'totals', 'lang'], 'string'],
            [['user_id'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lang' => 'Lang',
            'user_id' => 'User ID',
            'order_id' => 'Order ID',
            'user_basket' => 'User Basket',
            'information' => 'Information',
            'payment_information' => 'Payment Information',
            'totals' => 'Totals',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
