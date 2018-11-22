<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%pages_content_description}}".
 *
 * @property int $id
 * @property int $parent_id
 * @property int $lang_id
 * @property string $content
 */
class PagesContentDescription extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pages_content_description}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'lang_id'], 'required'],
            [['parent_id', 'lang_id'], 'integer'],
            [['content'], 'string'],
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
            'content' => 'Контент',
        ];
    }

    public function getPagesContent()
    {
        return $this->hasOne(PagesContent::className(), ['id' => 'parent_id']);
    }
}
