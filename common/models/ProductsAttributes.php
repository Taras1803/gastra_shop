<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%product_attributes}}".
 *
 * @property int $id
 * @property string $slug
 * @property string $ru
 * @property string $uk
 */
class ProductsAttributes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products_attributes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'ru', 'uk'], 'required'],
            [['slug'], 'string', 'max' => 100],
            [['ru', 'uk'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Уникальное имя',
            'ru' => 'Название на русском',
            'uk' => 'Название на украинском',
        ];
    }

    static function getAttributeIdBySlug($slug)
    {
        return self::find()->where(['slug' => $slug])->one()->id;
    }
}
