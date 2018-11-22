<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%promo_codes}}".
 *
 * @property int $id
 * @property string $promo_code
 * @property int $type
 * @property int $value
 * @property int $start_date
 * @property int $finish_date
 * @property int $status
 */
class PromoCodes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%promo_codes}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['promo_code', 'value'], 'required'],
            [['promo_code'], 'string'],
            [['type', 'status'], 'integer'],
            [['start_date', 'finish_date'], 'default', 'value' => null]
        ];
    }

    /**
     * {@inheritdoc}
     * type 1 - Одноразовый 2 - Временной
     * status 0 - Выкл 1 - Вкл
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'promo_code' => 'Промокод',
            'type' => 'Тип',
            'value' => 'Скидка',
            'start_date' => 'Дата начала',
            'finish_date' => 'Дата окончания',
            'status' => 'Статус',
        ];
    }

    public static function getTypes()
    {
        return [
            1 => 'Безвременный',
            2 => 'Временный',
        ];
    }

    public static function getStatus()
    {
        return [
            0 => 'Не активный',
            1 => 'Активный',
        ];
    }

    static function clearCurrent()
    {
        Yii::$app->session->remove('user_promo_code');
    }

    static function getCurrent()
    {
        $promoCode = Yii::$app->session->get('user_promo_code', false);
        if ($promoCode && self::checkCurrent($promoCode['id'])) {
            return $promoCode;
        }

        return false;
    }

    private static function checkCurrent($id)
    {
        // проверка на статус и так же на тип (если 2 - то нужно что бы попадал во временные рамки) Возвратить true или false
        return true;
    }

    static function check($promoCode)
    {
        $json = [
            'error' => 0,
            'text' => '',
        ];
        $promo = PromoCodes::find()->where(['promo_code' => $promoCode])->andWhere(['status' => 1])->one();

        if ($promo) {
            if ($promo->type == 2 && $promo->finish_date < time()) {
                $json['error'] = 1;
                $json['text'] = Yii::t('main', 'promocode_expired');
            } elseif (($promo->type == 2 && $promo->finish_date > time()) || $promo->type == 1) {
                $data = [
                    'id' => $promo->id,
                    'promo_code' => $promo->promo_code,
                    'value' => $promo->value,
                ];
                self::set($data);
                $json['error'] = 0;
                $json['value'] = $promo->value;
                $json['text'] = Yii::t('main', 'promocode_found');
            }
        } else {
            $json['error'] = 1;
            $json['text'] = Yii::t('main', 'promocode_not_found');
        }
        return $json;
    }

    private static function set($promoCode)
    {
        Yii::$app->session->set('user_promo_code', $promoCode);
    }
}

