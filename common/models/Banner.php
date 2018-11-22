<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property int $id
 * @property string $slug
 * @property string $image
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class Banner extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%banner}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image'], 'required'],
            [['status', 'sort'], 'integer'],
            [['image'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Изображение',
            'status' => 'Статус',
            'sort' => 'Порядковый номер',

        ];
    }

    public static function getStatus()
    {
        return [
            0 => 'Выкл',
            1 => 'Вкл',
        ];
    }

    public function getBannerDescriptions()
    {
        $lang = Lang::getCurrent();
        return $this->hasOne(BannerDescription::class, ['parent_id' => 'id'])
            ->where(['lang_id' => $lang->id]);
    }
}
