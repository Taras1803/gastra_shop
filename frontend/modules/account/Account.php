<?php

namespace frontend\modules\account;

use yii;
use common\models\Lang;
/**
 * account module definition class
 */
class Account extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\account\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
//        $current = Lang::getCurrent();
//        if($current->url == 'ru')
//            $homeUrl = '/';
//        else
//            $homeUrl = '/' . $current->url . '/';
//        if (Yii::$app->user->isGuest){
//            Yii::$app->getResponse()->redirect($homeUrl)->send();
//            Yii::$app->end();
//        }

        parent::init();

        // custom initialization code goes here
    }
}
