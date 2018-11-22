<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%options}}".
 *
 * @property integer $id
 * @property string $slug
 * @property string $value
 * @property string $description
 * @property integer $show
 */
class Options extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%options}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug'], 'required'],
            [['show'], 'integer'],
            [['slug', 'value', 'description'], 'string', 'max' => 255],
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
            'value' => 'Value',
            'description' => 'Description',
            'show' => 'Show',
        ];
    }

    public static function saveOption($data){
        if($data['id'] == 0){
            $option = new Self();
            $option->slug = $data['slug'];
            $option->value = $data['value'];
            $option->description = $data['description'];
        }else{
            $option = Self::findOne($data['id']);
            $option->value = $data['value'];
            if(isset($data['description']))
                $option->description = $data['description'];
        }
        if($option->save())
            return true;
        else
            return false;
    }

    public static function getBySlug($slug){
        $option = Self::find()->where(['slug' => $slug])->one();
        return $option->value;
    }

    public static function saveBySlug($slug, $value){
        $option = Self::find()->where(['slug' => $slug])->one();
        $option->value = $value;
        $option->save();
    }

    public static function getAllOptions(){
        $options = Self::find()->all();
        $data = [];
        foreach ($options as $option)
            $data[$option->slug] = $option->value;

        return $data;
    }
}
