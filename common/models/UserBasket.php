<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_basket}}".
 *
 * @property integer $user_id
 * @property string $params
 */
class UserBasket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_basket}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['params'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'params' => 'Params',
        ];
    }
}
