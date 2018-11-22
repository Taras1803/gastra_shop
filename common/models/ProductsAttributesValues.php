<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%products_attributes_values}}".
 *
 * @property int $id
 * @property int $product_attributes_id
 * @property string $ru
 * @property string $uk
 * @property string $value
 */
class ProductsAttributesValues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products_attributes_values}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_attributes_id', 'value'], 'required'],
            [['product_attributes_id'], 'integer'],
            [['ru', 'uk', 'value'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_attributes_id' => 'Product Attributes ID',
            'ru' => 'Ru',
            'en' => 'uk',
            'value' => 'Value',
        ];
    }
}
