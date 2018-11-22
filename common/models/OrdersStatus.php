<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%orders_status}}".
 *
 * @property int $id
 * @property string $ru
 * @property string $uk
 * @property int $color
 */
class OrdersStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%orders_status}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ru', 'uk', 'color'], 'required'],
            [['id'], 'integer'],
            [['ru', 'uk', 'color'], 'string', 'max' => 50],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№ (Уникальное числовое значение)',
            'ru' => 'RU',
            'uk' => 'UA',
            'color' => 'Цвет',
        ];
    }

    public static function getStatusName($id)
    {
        $lang = Lang::getCurrent();
        return self::findOne($id)->{$lang->url};
    }

    static function getAll()
    {
        $data = [];
        foreach (self::find()->all() as $status)
            $data[$status->id] = [
                'title' => $status->ru,
                'color' => $status->color,
            ];

        return $data;
    }
}
