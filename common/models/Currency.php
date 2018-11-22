<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%currency}}".
 *
 * @property int $id
 * @property string $code
 * @property string $value
 * @property string $symbol
 * @property int $active
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%currency}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'value', 'symbol', 'active'], 'required'],
            [['value'], 'number'],
            [['active'], 'integer'],
            [['code'], 'string', 'max' => 10],
            [['symbol'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Код',
            'value' => 'Значение',
            'symbol' => 'Символ',
            'active' => 'Основная',
        ];
    }

    static function setCurrent($id = 0)
    {
        if ($id) {
            $currency = self::findOne($id);
            if ($currency) {
                Yii::$app->session->set('bl_currency', [
                    'id' => $currency->id,
                    'code' => $currency->code,
                    'value' => $currency->value,
                    'symbol' => $currency->symbol,
                ]);

                return true;
            }
        }

        $currency = self::find()->where(['active' => 1])->one();

        Yii::$app->session->set('bl_currency', [
            'id' => $currency->id,
            'code' => $currency->code,
            'value' => $currency->value,
            'symbol' => $currency->symbol,
        ]);

        return true;
    }

    static function getCurrent()
    {
        $current = Yii::$app->session->get('bl_currency', false);
        if ($current)
            return $current;

        $currency = self::find()->where(['active' => 1])->one();

        $current = [
            'id' => $currency->id,
            'code' => $currency->code,
            'value' => $currency->value,
            'symbol' => $currency->symbol,
        ];

        Yii::$app->session->set('bl_currency', $current);

        return $current;
    }


    public static function priceCalculation($value)
    {
        $currency = self::getCurrent();
        if ($value >= 0)
            $new_price = round($value * (1 / $currency['value']), 2);
        else
            $new_price = -round(((-1) * $value * (1 / $currency['value'])),2);

        return $new_price;
    }

    public static function priceCurrencyCalculation($value, $currency)
    {
        return ceil($value * (1 / $currency));
    }

    public static function priceCalculateBack($value = 0, $fromCurrency = null, $ceil = false)
    {
        return ceil(($fromCurrency['value'] * $value) / 100) * 100;
    }

    public static function recalculation($value)
    {
        $currency = self::getCurrent();

        return ceil($value * $currency['value']);
    }
}
