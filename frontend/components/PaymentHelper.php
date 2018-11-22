<?php

namespace frontend\components;

use common\models\Lang;
use common\models\Options;
use Yii;
use \yii\helpers\Url;

class PaymentHelper
{
    static function getPaymentMethods()
    {
        return [
            'cod' => [
                'slug' => 'cod',
                'title' => Yii::t('main', 'payment_method_cod'),
                'name' => 'Наложенный платеж',
            ],
            'card_transfer' => [
                'slug' => 'card_transfer',
                'title' => Yii::t('main', 'card_transfer'),
                'name' => 'Перевод на карту',
            ],
            'paypal' => [
                'slug' => 'paypal',
                'title' => 'PayPal',
                'name' => 'PayPal',
            ],
        ];
    }

    static function liqPay($order_id, $amount, $currency_code)
    {
        $options = Options::getAllOptions();
        $public_key = $options['liqpay_public_key'];
        $private_key = $options['liqpay_private_key'];
        $return_url = Url::to(['/successful', 'status' => 'completed'], true);
        $server_url = Url::home(true) . 'actions/liqpay-listener';
        $data = [
            'version' => '3',
            'action' => 'pay',
            'amount' => $amount,
            'public_key' => $public_key,
            'currency' => $currency_code,     //'EUR','UAH','USD','RUB','RUR'
            'description' => 'Payment on the Gastrashop.com.ua',
            'order_id' => $order_id . '_' . time(),
            'sandbox' => $options['liqpay_mode'],
            'language' => Lang::getCurrent()->url,
            'server_url' => $server_url,
            'result_url' => $return_url
        ];

        $action = 'https://www.liqpay.com/api/3/checkout';
        $data_encode = base64_encode(json_encode($data));
        $signature = base64_encode(sha1($private_key . $data_encode . $private_key, 1));

        return sprintf('
                <form method="POST" accept-charset="utf-8" action="%s">
                    <input type="hidden" name="data" value="%s" />
                    <input type="hidden" name="signature" value="%s" />
                    <input type="submit" class="btn btn--blue" value="LiqPay">
                </form>',
            $action,
            $data_encode,
            $signature
        );
    }

    public static function payPal($order_id, $amount, $shipping, $currency_code = 'EUR')
    {
        $action = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        $business = Options::getBySlug('paypal_business');
        $item_name = 'order_' . $order_id;
        $return_url = Url::to(['/successful', 'status' => 'completed'], true);
        $notify_url = Url::home(true) . 'actions/paypal-listener';
        $cancel_return = Url::to(['/checkout'], true);

        return sprintf('
            <form id="paypal_form" method="POST" action="%s" accept-charset="utf-8">
                <input type="hidden" id="amount" name="amount" value="%s"/>
                <input type="hidden" name="cmd" value="_xclick"/>
                <input type="hidden" name="business" value="%s"/>
                <input type="hidden" name="item_name" value="%s"/>
                <input type="hidden" name="item_number" value="gastrashop"/>
                <input type="hidden" name="quantity" value="1"/>
                <input type="hidden" name="currency_code" value="%s"/>
                <input type="hidden" name="shipping" value="%s"/>
                <input type="hidden" name="return" value="%s"/>
                <input type="hidden" name="notify_url" value="%s"/>
                <input type="hidden" name="rm" value="2"/>
                <input type="hidden" name="cancel_return" value="%s"/>
                <input type="hidden" name="custom" value="%s"/>
                <input type="submit"/>
            </form>
            ',
            $action,
            $amount,
            $business,
            $item_name,
            $currency_code,
            $shipping,
            $return_url,
            $notify_url,
            $cancel_return,
            $order_id
        );
    }

    static function checkoutForm($order_id, $status)
    {
        $action = Url::to(['/successful', 'status' => 'completed']);
        $data = [
            'order_id' => $order_id,
            'status' => $status,
        ];

        $data_encode = base64_encode(json_encode($data));

        return sprintf('
                <form method="POST" accept-charset="utf-8" action="%s">
                    <input type="hidden" name="checkoutData" value="%s" />
                    <input type="submit" class="btn btn--black" value="%s">
                </form>',
            $action,
            $data_encode,
            Yii::t('main', 'checkout')
        );
    }

    static function getFormBySlug($slug, $params)
    {
        if($slug == 'cod')
            return self::checkoutForm($params['order_id'], $params['status']);
        else if ($slug == 'card_transfer')
            return self::liqPay($params['order_id'], $params['amount'], $params['currency_code']);
        else if ($slug == 'paypal')
            return self::payPal($params['order_id'], $params['amount'], 0, $params['currency_code']);
    }

    public static function liqpayListener()
    {
        $postData = Yii::$app->request->post('data', []);
        if ($postData) {
            $decodeData = base64_decode($postData);
            $json = json_decode($decodeData);
            if ($json->status == 'success' || $json->status == 'sandbox') {
                $order_id = explode('_', $json->order_id);
                return OrdersHelper::saveOrder((int)$order_id[0], [
                    'status' => 1,
                    'payment_information' => [
                        [
                            'name' => 'Статус оплаты',
                            'value' => $json->status,
                        ],
                        [
                            'name' => 'ID платежа',
                            'value' => $json->payment_id,
                        ],
                        [
                            'name' => 'Тип оплаты',
                            'value' => $json->paytype,
                        ],
                        [
                            'name' => 'Сумма',
                            'value' => $json->amount . ' ' . $json->currency,
                        ]
                    ]
                ]);
            } else
                return false;
        } else
            return false;
    }

    public static function paypalListener()
    {
        $ipn = new PaypalIPN();
        $ipn->useSandbox();
        $ipn->usePHPCerts();
        $verified = $ipn->verifyIPN();
        if ($verified) {
            OrdersHelper::createOrder($_POST);
            header("HTTP/1.1 200 OK");
        } else
            return false;
    }

    static function prepareFormData($data)
    {
        $decodeData = base64_decode($data);
        $json = json_decode($decodeData);

        if($json->order_id && $json->status){
            return OrdersHelper::saveOrder($json->order_id, [
                'status' => 2,
                'payment_information' => []
            ]);
        }
    }
}