<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property int $id
 * @property string $slug
 * @property string $images
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'images', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['slug', 'images'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Заголовок',
            'slug' => 'Ссылка',
            'images' => 'Изображение',
            'status' => 'Статус',
            'created_at' => 'Дата Добавления',
            'updated_at' => 'Дата Обновления',
        ];
    }

    public static function getStatus()
    {
        return [
            0 => 'Выкл',
            1 => 'Вкл',
        ];
    }

    public function getNewsDescriptions()
    {
        $lang = Lang::getCurrent();
        return $this->hasOne(NewsDescriptions::class, ['parent_id' => 'id'])
            ->where(['lang_id' => $lang->id]);
    }

    public function getNext()
    {
        $next = self::find()->where(['>', 'created_at', $this->created_at])->orderBy(['created_at' => SORT_ASC])->one();
        if (!$next){
            $min = self::find()->min('created_at');
            $next = self::findOne(['created_at' => $min]);
        }
        return $next;
    }

    public function getPrev()
    {
        $prev = self::find()->where(['<', 'created_at', $this->created_at])->orderBy(['created_at' => SORT_DESC])->one();
        if (!$prev){
            $max = self::find()->max('created_at');
            $prev = self::findOne(['created_at' => $max]);
        }
        return $prev;
    }
}
