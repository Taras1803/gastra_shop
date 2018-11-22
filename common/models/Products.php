<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property int $id
 * @property string $slug
 * @property string $images
 * @property string $price
 * @property string $action_price
 * @property int $action
 * @property int $type
 * @property string $article
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%products}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'price', 'images', 'created_at', 'updated_at','action'], 'required'],
            [['price', 'action_price'], 'number'],
            [['action', 'status', 'type', 'created_at', 'updated_at'], 'integer'],
            [['slug', 'images', 'article'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Ссылка',
            'images' => 'Изображение',
            'price' => 'Цена',
            'action' => 'Скидка',
            'type' => 'Тип',
            'article' => 'Артикул',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public static function getStatus()
    {
        return [
            0 => 'Нет на складе',
            1 => 'В наличии',
        ];
    }

    public static function getTypes()
    {
        return [
            1 => 'Шт',
            2 => 'Вес',
        ];
    }

    public function getProductsDescriptions()
    {
        $lang = Lang::getCurrent();
        return $this->hasOne(ProductsDescriptions::class, ['parent_id' => 'id'])
            ->where(['lang_id' => $lang->id]);
    }
}
