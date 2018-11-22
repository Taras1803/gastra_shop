<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%seo_descriptions}}".
 *
 * @property int $id
 * @property int $parent_id
 * @property int $lang_id
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 */
class SeoDescription extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%seo_descriptions}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'lang_id', 'meta_title'], 'required'],
            [['parent_id', 'lang_id'], 'integer'],
            [['meta_description'], 'string'],
            [['meta_title', 'meta_keywords'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Seo ID',
            'lang_id' => 'Lang ID',
            'meta_title' => 'Meta Заголовок',
            'meta_description' => 'Meta Описание',
            'meta_keywords' => 'Meta Ключевые слова',
        ];
    }

    public function getSeo()
    {
        return $this->hasOne(Seo::class, ['id' => 'parent_id']);
    }
}
