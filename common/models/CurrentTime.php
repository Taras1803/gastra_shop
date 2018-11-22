<?php

namespace common\models;

use Yii;

class CurrentTime
{
    static function setUserOffsetTime($data)
    {
        if($data['dtz']){
            Yii::$app->session->set('userTime', (int)$data['dtz'] * (3600));
        }
    }

    static function getUserOffsetTime()
    {
        return Yii::$app->session->get('userTime', 7200);
    }

    static function getUserTimeSession()
    {
        return Yii::$app->session->get('userTime', 'notSet');
    }
}