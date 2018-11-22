<?php

namespace common\models;

use Yii;
use backend\components\FileUploader;

/**
 * This is the model class for table "{{%theme_variables}}".
 *
 * @property int $id
 * @property string $slug
 * @property string $value
 * @property int $type
 * @property string $description
 */
class ThemeVariables extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%theme_variables}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug'], 'required'],
            [['value'], 'string'],
            [['type'], 'integer'],
            [['slug', 'description'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'value' => 'Значение',
            'type' => 'Тип',
            'description' => 'Описание',
        ];
    }

    public static function saveVariable($data){
        if($data['id'] == 0){
            $option = new Self();
            $option->slug = $data['slug'];
            $option->value = $data['value'];
            $option->type = $data['type'];
            $option->description = $data['description'];
        }else{
            $option = Self::findOne($data['id']);
            if($option->type == 1)
                FileUploader::uploadImage($data['value'], 'images/');
            $option->value = $data['value'];
            if(isset($data['description']))
                $option->description = $data['description'];
        }
        if($option->save())
            return true;
        else
            return false;
    }

    public static function getValueBySlug($slug)
    {
        return self::find()->where(['slug' => $slug])->one()->value;
    }

    public static function getValues()
    {
        $data = [];
        foreach (self::find()->all() as $item)
            $data[$item->slug] = $item->value;

        return $data;
    }

    static function getImagePath()
    {
        return Yii::getAlias('@storage/web/source/images/');
    }
}
