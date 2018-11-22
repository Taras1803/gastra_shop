<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%products_descriptions}}".
 *
 * @property int $id
 * @property int $parent_id
 * @property int $lang_id
 * @property string $title
 * @property string $consist
 * @property string $description
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 */
class ProductsDescriptions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%products_descriptions}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'lang_id', 'title'], 'required'],
            [['parent_id', 'lang_id'], 'integer'],
            [['consist', 'description', 'meta_description'], 'string'],
            [['title', 'meta_title', 'meta_keywords'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'lang_id' => 'Lang ID',
            'title' => 'Название',
            'consist' => 'Состав',
            'description' => 'Описание',
            'meta_title' => 'Meta Заголовок',
            'meta_description' => 'Meta Описание',
            'meta_keywords' => 'Meta Ключи',
        ];
    }

    public function getProducts()
    {
        return $this->hasOne(Products::class, ['id' => 'parent_id']);
    }
}
