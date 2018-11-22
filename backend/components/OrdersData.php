<?php

namespace backend\components;

use common\models\User;
use Yii;
use common\models\CheckoutSession;
use common\models\CurrentTime;
use common\models\OrdersStatus;
use common\models\OrdersStatusHistory;

class OrdersData
{
    static function getData($model)
    {
        $userTime = CurrentTime::getUserOffsetTime();
        $session = CheckoutSession::findOne($model->session_id);
        $information = json_decode($session->information, true);
        $totals = json_decode($session->totals, true);
        $payment = json_decode($session->payment_information, true);
        $basket = json_decode($session->user_basket, true);
        $user_discount = 0;
        if($model->user_id){
            $user = User::findOne($model->user_id);
            $user_discount = $user->discount;
        }

        return [
            'user_lang' => $session->lang,
            'user_discount' => $user_discount,
            'currency' => 'UAH',
            'date' => date("H:i d.m.Y",$model->created_at + $userTime),
            'information' => $information,
            'totals' => $totals,
            'order_status' => OrdersStatus::findOne($model->status_id),
            'payment' => $payment,
            'products' => self::getOrderProducts($basket),
            'status_history' => self::getStatusHistory($model->id)
        ];
    }

    private static function getStatusHistory($id)
    {
        $userTime = CurrentTime::getUserOffsetTime();
        $oh = OrdersStatusHistory::find()->where(['order_id' => $id])->all();
        $data = [];
        if($oh){
            foreach ($oh as $item){
                $temp = OrdersStatus::findOne($item->status_id);
                $data[] = [
                    'id' => $item->id,
                    'status' => $item->status_id,
                    'name' => $temp->ru,
                    'send' => ($item->send)? 'Да' : 'Нет',
                    'color' => $temp->color,
                    'date' => date("H:i d.m.Y", $item->created_at + $userTime),
                    'comment' => $item->comment,
                ];
            }
        }

        return $data;
    }

    private static function getOrderProducts($basket)
    {
        $data = [];
        foreach ($basket as $product){
            $data[] = [
                'id' => $product['id'],
                'image' => Yii::$app->glide->createSignedUrl([
                    'glide/index',
                    'path' => 'products/' . $product['image'],
                    'w' => 225
                ], true),
                'title' => $product['title'],
                'count' => $product['counts'][$product['count']],
                'price' => $product['price'],
                'attributes' => $product['attributes'],
            ];
        }

        return $data;
    }
}