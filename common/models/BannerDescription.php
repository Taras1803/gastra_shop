<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%banner_description}}".
 *
 * @property int $id
 * @property int $parent_id
 * @property int $lang_id
 * @property string $title
 * @property string $description
 * @property string $link_name
 * @property string $link
 */
class BannerDescription extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%banner_description}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'lang_id'], 'required'],
            [['parent_id'], 'integer'],
            [['description'], 'string'],
            [['title', 'link_name', 'link'], 'string', 'max' => 255],
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
            'title' => 'Заголовк',
            'description' => 'Описание',
            'link_name' => 'Текст ссылки',
            'link' => 'Ссылка',
        ];
    }
}
