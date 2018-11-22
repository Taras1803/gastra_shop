<?php

namespace frontend\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ThemeLinkPager extends \yii\widgets\LinkPager
{
    public $route;

    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = $this->linkContainerOptions;
        $linkWrapTag = ArrayHelper::remove($options, 'tag', 'li');
        Html::addCssClass($options, empty($class) ? $this->pageCssClass : $class);

        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);
            $disabledItemOptions = $this->disabledListItemSubTagOptions;
            $tag = ArrayHelper::remove($disabledItemOptions, 'tag', 'span');

            return Html::tag($linkWrapTag, Html::tag($tag, $label, $disabledItemOptions), $options);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;

        $url = $this->pagination->createUrl($page);

        $url = str_replace(['/blog/index', '/catalog/index'], ['/blog/', '/catalog/index'], $url);

        return Html::tag($linkWrapTag, Html::a($label, $url, $linkOptions), $options);
    }
}