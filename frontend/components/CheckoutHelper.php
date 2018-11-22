<?php

namespace frontend\components;

use Yii;
use common\models\CheckoutSession;
use common\models\Lang;
use common\models\DeliveryMethods;
use common\models\CurrentTime;
use common\models\Orders;
use common\models\Currency;
use common\models\Countries;
use common\models\PromoCodes;

class CheckoutHelper
{
    static function getCheckoutData()
    {
        $data = [];
        $ub = BasketHelper::getBasketData();
        if (!$ub)
            return $data;

        if (Yii::$app->user->isGuest) {
            $data['user_is_login'] = false;
            $user_id = Yii::$app->session->getId();
        } else {
            $data['user_is_login'] = true;
            $user_id = Yii::$app->user->id;
        }

        $lang = Lang::getCurrent();
        $currency = Currency::getCurrent();

        $checkoutSession = CheckoutSession::findOne(['user_id' => (string)$user_id, 'status' => 0]);
        if (!$checkoutSession) {
            $checkoutSession = new CheckoutSession();
            $checkoutSession->time_offset = CurrentTime::getUserOffsetTime();
            $checkoutSession->user_id = (string)$user_id;
            $checkoutSession->order_id = 0;
            $checkoutSession->status = 0;
            $checkoutSession->created_at = time();
            $information = self::getFormData();
        } else {
            $information = json_decode($checkoutSession->information, true);
        }

        $data['currency'] = $currency;
        $data['products_count'] = $ub['products_count'];
        $data['countries'] = Countries::getCountries();
        $data['information'] = $information;
        $data['payment_methods'] = PaymentHelper::getPaymentMethods();
        $data['delivery_methods'] = DeliveryMethods::getMethods();
        $data['totals'] = self::getTotals([
            'products_total' => $ub['totals'],
            'delivery_method' => $information['delivery_method'],
        ]);

        $checkoutSession->lang = $lang->url;
        $checkoutSession->currency = json_encode($currency);
        $checkoutSession->user_basket = json_encode($ub['products']);
        $checkoutSession->information = json_encode($information);
        $checkoutSession->payment_information = json_encode($data['payment_methods'][$information['payment_method']]);
        $checkoutSession->totals = json_encode($data['totals']);
        if (!$checkoutSession->save())
            return [];

        return $data;
    }

    private static function getFormData()
    {
        $data = [];
        $data['email'] = '';
        $data['first_name'] = '';
        $data['last_name'] = '';
        $data['middle_name'] = '';
        $data['phone'] = '+380';
        $data['address'] = '';
        $data['payment_method'] = 'card_transfer';
        $data['delivery_method'] = 'pickup';
        $data['country'] = '';
        $data['city'] = '';
        $data['address'] = '';
        $data['np_detachment'] = '';
        $data['comment'] = '';
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity;
            $data['email'] = $user->email;
            $data['first_name'] = $user->first_name;
            $data['last_name'] = $user->last_name;
            $data['middle_name'] = $user->middle_name;
            $data['phone'] = $user->phone;
            $data['address'] = $user->address;
            $data['city'] = $user->city;
            $data['country'] = $user->country;
        }

        return $data;
    }

    private static function getTotals($params)
    {
        $data = [];
        $total = 0;
        $total += $params['products_total'];
        $data['sub_total'] = [
            'price' => $total,
            'title_text' => Yii::t('mail', 'sub_total'),
        ];

        $promoCode = PromoCodes::getCurrent();
        if($promoCode){
            $total = round($total - ($total / 100 * $promoCode['value']), 2);
            $data['promo_code'] = [
                'id' => $promoCode['id'],
                'promo_code' => $promoCode['promo_code'],
                'value' => $promoCode['value'],
                'title' => '-' . $promoCode['value'] . '%',
                'price' => $total,
                'title_text' => Yii::t('mail', 'promo_code'),
            ];
        }

        $data['delivery'] = [
            'id' => $params['delivery_method'],
            'price' => 0,
            'title_text' => Yii::t('mail', 'delivery'),
        ];

        $data['total'] = [
            'price' => $total,
            'title_text' => Yii::t('mail', 'total_text'),
        ];

        return $data;
    }

    static function saveInformation($post)
    {
        $json = [];
        $json['error'] = 0;
        $json['text'] = '';
        $json['action'] = 'send_payment_form';

        if ($post['last_name'] && $post['first_name'] && $post['email'] && $post['delivery_method'] && $post['payment_method']) {

            if (Yii::$app->user->isGuest)
                $user_id = Yii::$app->session->getId();
            else
                $user_id = Yii::$app->user->id;

            $checkoutSession = CheckoutSession::findOne(['user_id' => (string)$user_id, 'status' => 0]);
            if (!$checkoutSession) {
                $json['error'] = 1;
                $json['text'] = Yii::t('main', 'error_incorrect_form_data');
                return $json;
            }

            Lang::setCurrent($checkoutSession->lang);

            $delivery_methods = DeliveryMethods::getMethods();
            if (!isset($delivery_methods[$post['delivery_method']])) {
                $json['error'] = 1;
                $json['text'] = Yii::t('main', 'error_incorrect_form_data');
                return $json;
            }

            $payment_methods = PaymentHelper::getPaymentMethods();
            if (!isset($payment_methods[$post['payment_method']])) {
                $json['error'] = 1;
                $json['text'] = Yii::t('main', 'error_incorrect_form_data');
                return $json;
            }

            $order = Orders::findOne(['session_id' => $checkoutSession->id, 'status_id' => 0]);
            if (!$order)
                $order = new Orders();

            $order->session_id = $checkoutSession->id;
            if (!Yii::$app->user->isGuest)
                $order->user_id = $user_id;

            if (!isset($post['country']))
                $post['country'] = '';
            if (!isset($post['city']))
                $post['city'] = '';
            if (!isset($post['address']))
                $post['address'] = '';
            if (!isset($post['np_detachment']))
                $post['np_detachment'] = '';

            $checkoutSession->information = json_encode($post);
            $checkoutSession->payment_information = json_encode($payment_methods[$post['payment_method']]);
            $totals = json_decode($checkoutSession->totals, true);
            $currencyData = json_decode($checkoutSession->currency, true);

            $order->user_name = vsprintf("%s %s", [$post['last_name'], $post['first_name']]);
            $order->email = $post['email'];
            $order->phone = $post['phone'];
            $order->delivery_method = $delivery_methods[$post['delivery_method']]['name'];
            $order->payment_method = $payment_methods[$post['payment_method']]['name'];
            $order->total_price = $totals['total']['price'];
            $order->status_id = 0;
            $order->currency = $currencyData['code'];
            $order->created_at = time();

            if ($order->save()) {
                PromoCodes::clearCurrent();
                $checkoutSession->order_id = $order->id;
                if($checkoutSession->save()){
                    $json['form'] = PaymentHelper::getFormBySlug($post['payment_method'], [
                        'order_id' => $order->id,
                        'status' => 1,
                        'amount' =>  $order->total_price,
                        'currency_code' =>  $order->currency,
                    ]);
                } else {
                    $json['error'] = 1;
                    $json['text'] = Yii::t('main', 'error_incorrect_form_data');
                }
            } else {
                $json['error'] = 1;
                $json['text'] = Yii::t('main', 'error_incorrect_form_data');
            }

        } else {
            $json['error'] = 1;
            $json['text'] = Yii::t('main', 'error_incorrect_form_data');
        }

        return $json;
    }

}