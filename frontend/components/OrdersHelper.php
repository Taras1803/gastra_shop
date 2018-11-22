<?php

namespace frontend\components;

use Yii;
use \yii\helpers\Url;
use common\models\Orders;
use common\models\Lang;
use common\models\CheckoutSession;
use common\models\Notifications;
use common\models\OrdersStatusHistory;
use common\models\DeliveryMethods;
use common\models\OrdersStatus;
use common\models\Options;
use common\models\PagesContent;
use common\models\Currency;
use common\models\Products;

class OrdersHelper
{
    static function saveOrder($order_id, $params = [])
    {
        $order = Orders::findOne(['id' => (int)$order_id, 'status_id' => 0]);
        if ($order) {
            $checkoutSession = CheckoutSession::findOne(['id' => $order->session_id, 'status' => 0]);
            if (!$checkoutSession)
                return false;
            Lang::setCurrent($checkoutSession->lang);
            $order->status_id = $params['status'];
            $order->created_at = time();
            $checkoutSession->payment_information = json_encode($params['payment_information']);
            $checkoutSession->status = 1;
            if ($order->save() && $checkoutSession->save()) {
                $order_status = OrdersStatus::findOne($order->status_id);
                $information = json_decode($checkoutSession->information, true);
                $totals = json_decode($checkoutSession->totals, true);
                $delivery_methods = DeliveryMethods::getMethods();
                self::userNotification([
                    'order_id' => $order->id,
                    'order_status_id' => $order->status_id,
                    'user_id' => $order->user_id,
                    'user_name' => vsprintf("%s %s", [$information['last_name'], $information['first_name']]),
                    'user_email' => $order->email,
                    'currency' => $order->currency,
                    'order_date' => $order->created_at + $checkoutSession->time_offset,
                    'order_status' => $order_status->{$checkoutSession->lang},
                    'delivery_method' => $delivery_methods[$information['delivery_method']]['title'],
                    'products' => self::saveOrderProducts($order->id, $checkoutSession->user_basket),
                    'total_info' => $totals,
                    'total_price' => $totals['total']['price'],
                    'information' => $information,
                ]);

                return true;
            } else
                return false;
        } else
            return false;
    }

    private static function saveOrderProducts($order_id, $user_basket)
    {
        $products_data = [];
        $user_basket = json_decode($user_basket, true);
        foreach ($user_basket as $product) {
            $productVariables = Products::find()->select(['price', 'action', 'type'])->where(['id' => $product['id']])->asArray()->one();
            $productDefaultPrice = ThemeHelper::priceCalculation($productVariables['price'], $productVariables['action']);
            $defaultWeight = ThemeHelper::getDefaultWeight();
            $currency = Currency::getCurrent();
            if ($productVariables['type'] == 2) {
                $productDefaultPrice = $productDefaultPrice . $currency['symbol'] . "/" . $defaultWeight . Yii::t('main', 'gr');
            } else {
                $productDefaultPrice = $productDefaultPrice . $currency['symbol'] . '/1' . Yii::t('main', 'pc');
            }
            $products_data[] = [
                'order_id' => $order_id,
                'product_id' => $product['id'],
                'slug' => $product['slug'],
                'image' => $product['image'],
                'title' => $product['title'],
                'count' => $product['counts'][$product['count']],
                'price' => $product['price'],
                'default_price' => $productDefaultPrice,
            ];
        }

        if ($products_data) {
            Yii::$app->db->createCommand()->batchInsert('sm_orders_products', ['order_id', 'product_id', 'slug', 'image', 'title', 'count', 'price', 'default_price'], $products_data)->execute();
            foreach ($products_data as $key => $product) {
                $products_data[$key]['url'] = Url::to(['/product']) . '/' . $product['slug'];
                $products_data[$key]['image'] = Yii::$app->glide->createSignedUrl([
                    'glide/index',
                    'path' => 'products/' . $product['image'],
                    'w' => 225
                ], true);
            }
        }

        return $products_data;
    }

    private static function userNotification($data)
    {
        $status_history = new OrdersStatusHistory();
        $status_history->order_id = $data['order_id'];
        $status_history->status_id = $data['order_status_id'];
        $status_history->created_at = time();
        $status_history->save();

        Notifications::addMessage(0, 1, 'new_order', [$data['order_id'], $data['order_id'], $data['order_status']]);
        BasketHelper::clearUserBasket($data['user_id']);
        if ($data['userId'] == 0)
            BasketHelper::clearSessionBasket($data['user_id']);

        Yii::$app
            ->mailer
            ->compose(
                ['html' => 'frontend/order-html'],
                ['data' => [
                    'order_id' => $data['order_id'],
                    'order_date' => date("H:i d.m.Y", $data['order_date']),
                    'user_name' => $data['user_name'],
                    'user_email' => $data['user_email'],
                    'order_status' => $data['order_status'],
                    'delivery_method' => $data['delivery_method'],
                    'products' => $data['products'],
                    'currency' => $data['currency'],
                    'total_info' => $data['total_info'],
                    'total_price' => $data['total_price'],
                    'information' => $data['information'],
                    'mail_shop_information' => PagesContent::getPagesContentBySlug('mail_shop_information')
                ]]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->params['site_name']])
            ->setTo([$data['user_email'], Options::getBySlug('admin_email')])
            ->setSubject(Yii::t('mail', 'new_order') . ' ' . Yii::$app->params['site_name'])
            ->send();
    }
}