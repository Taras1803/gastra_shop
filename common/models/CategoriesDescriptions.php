<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%categories_descriptions}}".
 *
 * @property int $id
 * @property int $lang_id
 * @property int $parent_id
 * @property string $name
 * @property string $description
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 */
class CategoriesDescriptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%categories_descriptions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'lang_id', 'name'], 'required'],
            [['parent_id', 'lang_id'], 'integer'],
            [['name', 'meta_title', 'meta_keywords'], 'string', 'max' => 255],
            [['description', 'meta_description'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Category ID',
            'lang_id' => 'Lang ID',
            'name' => 'Название',
            'description' => 'Описание',
            'meta_title' => 'Meta Заголовок',
            'meta_description' => 'Meta Описание',
            'meta_keywords' => 'Meta Ключи',
        ];
    }

    public function getCategories()
    {
        return $this->hasOne(Categories::class, ['id' => 'parent_id']);
    }
}
