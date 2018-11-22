<?php

namespace frontend\widgets;

use yii;
use common\models\Lang;

class Breadcrumbs extends \yii\bootstrap\Widget
{
    public  $breadcrumbs = [];

    public function run()
    {
        return $this->render('breadcrumbs/view', [
            'language' => Lang::getCurrent(),
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }
}