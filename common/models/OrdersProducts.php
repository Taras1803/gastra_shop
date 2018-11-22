<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%orders_products}}".
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property string $slug
 * @property string $image
 * @property string $title
 * @property string $count
 * @property string $price
 * @property string $default_price
 */
class OrdersProducts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%orders_products}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'slug', 'image', 'title', 'count', 'price'], 'required'],
            [['order_id', 'product_id'], 'integer'],
            [['price'], 'number'],
            [['slug', 'title', 'default_price'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 50],
            [['count'], 'string', 'max' => 20],
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
            'product_id' => 'Product ID',
            'slug' => 'Slug',
            'image' => 'Image',
            'title' => 'Title',
            'count' => 'Count',
            'price' => 'Price',
            'default_price' => 'Default price',
        ];
    }
}
