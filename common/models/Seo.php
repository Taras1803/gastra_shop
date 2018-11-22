<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%seo}}".
 *
 * @property int $id
 * @property string $slug
 * @property string $description
 */
class Seo extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%seo}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug'], 'required'],
            [['slug', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Ссылка',
            'description' => 'Описание',
        ];
    }

    public function getSeoDescriptions()
    {
        $lang = Lang::getCurrent();
        return $this->hasOne(SeoDescription::class, ['parent_id' => 'id'])
            ->where(['lang_id' => $lang->id]);
    }

    static function getDataBySlug($slug = '')
    {
        $data = [
            'meta_title' => Yii::$app->params['site_name'],
            'meta_description' => Yii::$app->params['site_name'],
            'meta_keywords' => Yii::$app->params['site_name'],
            'meta_img' => Yii::$app->glide->createSignedUrl([
                'glide/index',
                'path' => 'images/' . ThemeVariables::getValueBySlug('header_logo'),
                'w' => 192
            ], true),
            'url' => Yii::$app->params['siteUrl'] . $_SERVER['REQUEST_URI'],
        ];

        if($slug){
            $seo = self::findOne(['slug' => $slug]);
            if($seo){
                $description = $seo->getSeoDescriptions()->one();
                $data['meta_title'] = $description->meta_title;
                $data['meta_description'] = $description->meta_description;
                $data['meta_keywords'] = $description->meta_keywords;
            }
        }

        return $data;
    }
}
