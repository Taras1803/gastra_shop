<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%delivery-methods}}".
 *
 * @property int $id
 * @property string $slug
 * @property string $title_ru
 * @property string $title_uk
 * @property string $title_en
 * @property string $description_ru
 * @property string $description_uk
 * @property string $description_en
 */
class DeliveryMethods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%delivery_methods}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug'],'unique'],
            [['slug', 'title_ru', 'title_uk', 'title_en'], 'required'],
            [['description_ru', 'description_uk', 'description_en'], 'string'],
            [['slug', 'title_ru', 'title_uk', 'title_en'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Ключ',
            'title_ru' => 'Заголовок на русском',
            'title_uk' => 'Заголовок на украинском',
            'title_en' => 'Заголовок на английском',
            'description_ru' => 'Описание на русском',
            'description_uk' => 'Описание на украинском',
            'description_en' => 'Описание на английском',
        ];
    }

    static function getMethods()
    {
        $data = [];
        $methods = self::find()->all();
        $lang = Lang::getCurrent();
        foreach ($methods as $method)
            $data[$method->slug] = [
                'title' => $method->{'title_' . $lang->url},
                'name' => $method->title_ru,
                'description' => $method->{'description_' . $lang->url},
            ];

        return $data;
    }
}
