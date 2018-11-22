<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%products_to_attributes}}".
 *
 * @property int $id
 * @property int $product_id
 * @property int $attribute_id
 * @property int $attribute_value_id
 * @property string $price
 * @property int $sort
 */
class ProductsToAttributes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products_to_attributes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attribute_id', 'attribute_value_id', 'product_id'], 'required'],
            [['price'], 'number'],
            [['attribute_id', 'attribute_value_id', 'sort', 'product_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'attribute_id' => 'Attribute ID',
            'attribute_value_id' => 'Attribute Value ID',
            'sort' => 'Sort',
            'product_id' => 'product_id',
        ];
    }

    static function getProductAttributes($product_id)
    {
        $data = [];
        $values = self::find()->where(['product_id' => $product_id])->orderBy(['attribute_id' => SORT_ASC])->all();
        if ($values)
            foreach ($values as $value) {
                $product_attributes = ProductsAttributesValues::findAll(['product_attributes_id' => $value->attribute_id]);
                $data [] = [
                    'data' => $value,
                    'values' => $product_attributes,
                ];
            }
        return $data;
    }
}
