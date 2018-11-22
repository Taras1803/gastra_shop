<?php

namespace frontend\widgets;

use common\models\News;
use yii;
use yii\helpers\Url;
use common\models\ThemeVariables;
use common\models\PagesContent;

class Footer extends \yii\bootstrap\Widget
{
    public function init()
    {
    }

    public function run()
    {
        return $this->render('footer/view', [
            'menu' => $this->getMenu(),
            'theme_variables' => ThemeVariables::getValues(),
            'page_content' => PagesContent::getPagesContents(),
            'news' => News::find()->where(['status' => 1])->orderBy(['created_at' => SORT_DESC])->limit(3)->all(),
        ]);
    }

    private function getMenu()
    {
        return [
            'about_us' => [
                'title' => Yii::t('main', 'about_us'),
                'link' => Url::to(['/about-us']),
            ],
            'payment_delivery' => [
                'title' => Yii::t('main', 'payment_delivery'),
                'link' => Url::to(['/payment-delivery']),
            ],
            'contacts' => [
                'title' => Yii::t('main', 'contacts'),
                'link' => Url::to(['/contacts']),
            ],
            'blog' => [
                'title' => Yii::t('main', 'blog'),
                'link' => Url::to(['/blog']) . '/',
            ],
            'follow_us' => [
                'title' => Yii::t('main', 'follow_us'),
                'link' => 'javascript:void(0)',
            ],
        ];
    }
}