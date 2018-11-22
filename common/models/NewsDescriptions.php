<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%news_descriptions}}".
 *
 * @property int $id
 * @property int $parent_id
 * @property int $lang_id
 * @property string $title
 * @property string $short_description
 * @property string $description
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 */
class NewsDescriptions extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%news_descriptions}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'lang_id', 'title'], 'required'],
            [['parent_id', 'lang_id'], 'integer'],
            [['short_description', 'description', 'meta_title', 'meta_description'], 'string'],
            [['title', 'meta_keywords'], 'string', 'max' => 255],
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
            'title' => 'Заголовок',
            'short_description' => 'Краткое описание',
            'description' => 'Описание',
            'meta_title' => 'Meta Заголовок',
            'meta_description' => 'Meta Описание',
            'meta_keywords' => 'Meta Ключи',
        ];
    }

    public function getNews()
    {
        return $this->hasOne(News::class, ['id' => 'parent_id']);
    }
}
