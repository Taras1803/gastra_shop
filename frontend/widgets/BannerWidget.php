<?php

namespace frontend\widgets;

use common\models\Banner;
use yii;
use yii\bootstrap\Widget;
use yii\helpers\Url;
use common\models\Lang;
use common\models\ThemeVariables;


class BannerWidget extends Widget
{
    public function init()
    {
    }

    public function run()
    {
        $banners =  Banner::find()->where(['status' => 1])->all();
        return $this->render('banner/view', [
            'banners' => $banners,
        ]);
    }
}