<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%countries}}".
 *
 * @property integer $id
 * @property string $en
 * @property string $ru
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%countries}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['en', 'ru'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'en' => 'En',
            'ru' => 'Ru',
        ];
    }

    public static function getCountries()
    {
        $data = [];
        $lang = Lang::getCurrent();
        $url = $lang->url;
        if($url == 'uk')
            $url = 'ru';

        $countries = Countries::find()->orderBy([$url => SORT_ASC])->all();

        $data[1] = ($lang->url == 'uk')? 'Україна' : Countries::findOne(2)->{$url};
        $data[2] = Countries::findOne(1)->{$url};
        $data[3] = Countries::findOne(3)->{$url};

        foreach ($countries as $country){
            if($country->id > 3){
                $data[$country->id] = $country->{$url};
            }
        }

        return $data;
    }

    public static function getCountriesName()
    {
        $countries = Countries::find()->orderBy(['ru' => SORT_ASC])->all();
        $data = [];
        foreach ($countries as $country)
            $data[$country->ru] = $country->ru;

        return $data;
    }

    public static function getCountry($id)
    {
        $lang = Lang::getCurrent();
        $country = Countries::find()->where(['id' => $id])->one();
        return $country->{$lang->url};
    }
}
