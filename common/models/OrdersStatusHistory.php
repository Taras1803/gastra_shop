<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%orders_status_history}}".
 *
 * @property int $id
 * @property int $order_id
 * @property int $status_id
 * @property string $comment
 * @property int $send
 * @property int $created_at
 */
class OrdersStatusHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%orders_status_history}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'status_id', 'created_at'], 'required'],
            [['order_id', 'status_id', 'send', 'created_at'], 'integer'],
            [['comment'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'status_id' => 'Status ID',
            'comment' => 'Comment',
            'send' => 'Send',
            'created_at' => 'Created At',
        ];
    }

    static function changeStatus($data)
    {
        $user = Yii::$app->user->identity;
        $oh = new OrdersStatusHistory();
        $oh->order_id = (int)$data['order_id'];
        $oh->status_id = (int)$data['items']['status'];
        $oh->comment = $data['items']['comment'];
        $oh->created_at = time();
        $oh->save();
        $order = Orders::findOne((int)$data['order_id']);
        $order->status_id = $oh->status_id;
        $order->save();
        Notifications::addMessage((int)$user->id, 0, 'change_order_status', [$user->username, $data['order_id'], $data['order_id'], OrdersStatus::findOne($oh->status_id)->ru]);
    }

    static function sendUserMail($data)
    {
        $osh = self::findOne($data['history_id']);
        if($osh){
            Lang::setCurrent($data['lang']);
            $status = OrdersStatus::findOne($osh->status_id)->{$data['lang']};
            $osh->send = 1;
            Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'frontend/changeOrderStatus-html'],
                    ['data' => [
                        'orderId' => $osh->order_id,
                        'status' => $status
                    ]]
                )
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->params['site_name']])
                ->setTo($data['email'])
                ->setSubject(Yii::t('mail', 'change_order_status') . ' - ' . Yii::$app->params['site_name'])
                ->send();
            $osh->save();
        }
    }
}
