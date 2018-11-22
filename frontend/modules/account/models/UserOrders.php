<?php

namespace frontend\modules\account\models;

use Yii;
use frontend\components\ThemeHelper;
use yii\data\Pagination;
use common\models\Orders;
use common\models\OrdersProducts;

class UserOrders
{
    static function getUserOrders()
    {
        $data = [];
        $data['currency'] = ThemeHelper::getCurrency();
        $data['order_by'] = Yii::$app->request->get('order_by', 'new');
        $data['filters'] = self::getFilters();
        $data['current_sort'] = self::getFilters()[ $data['order_by']];
        $user = Yii::$app->user;

        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => Orders::find()->where(['user_id' => $user->id])->andWhere(['>', 'status_id', 0])->count()
        ]);

        $orders = Orders::find()
            ->where(['user_id' => $user->id])
            ->andWhere(['>', 'status_id', 0])
            ->orderBy(self::getFiltersSql($data['order_by']))
            ->limit($pagination->limit)
            ->offset($pagination->offset)
            ->all();

        $data['pagination'] = $pagination;
        $data['orders'] = [];
        if ($orders) {
            foreach ($orders as $order){
                $data['orders'][] = [
                    'item' => $order,
                    'products' => OrdersProducts::findAll(['order_id' => $order->id]),
                ];
            }
        }

        return $data;

    }
    private static function getFilters()
    {
        return [
            'new' => Yii::t('main', 'filter_new'),
            'old' => Yii::t('main', 'filter_old'),
            'price_low' => Yii::t('main', 'filter_price_low'),
            'price_height' => Yii::t('main', 'filter_price_height'),
        ];
    }

    private static function getFiltersSql($slug)
    {
        $data = [
            'new' => '`sm_orders`.`created_at` DESC',
            'old' => '`sm_orders`.`created_at` ASC',
            'price_height' => '`sm_orders`.`total_price` DESC',
            'price_low' => '`sm_orders`.`total_price` ASC',
        ];

        return $data[$slug];
    }
}