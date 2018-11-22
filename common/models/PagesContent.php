<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%pages_content}}".
 *
 * @property int $id
 * @property string $slug
 * @property string $description
 * @property int $created_at
 * @property int $updated_at
 */
class PagesContent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pages_content}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['slug', 'description'], 'string', 'max' => 255],
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
            'slug' => 'Slug',
            'description' => 'Описание',
            'created_at' => 'Дата Создания',
            'updated_at' => 'Дата Обновления',
        ];
    }

    public function getPagesContentDescription()
    {
        $lang = Lang::getCurrent();
        return $this->hasOne(PagesContentDescription::className(), ['parent_id' => 'id'])
            ->where(['lang_id' => $lang->id]);
    }

    static function getPagesContentBySlug($slug)
    {
       $model =  self::findOne(['slug' => $slug]);
       if(!$model)
           return '';

        $lang = Lang::getCurrent();
        $description = PagesContentDescription::findOne(['lang_id' => $lang->id, 'parent_id' => $model->id]);
        if($description)
            return $description->content;
        else
            return '';
    }

    static function getPagesContents()
    {
        $data = [];
        $pc =  self::find()->all();
        foreach ($pc as $item)
            $data[$item->slug] = $item->getPagesContentDescription()->one()->content;

        return $data;
    }
}
