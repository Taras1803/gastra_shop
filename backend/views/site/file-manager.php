<?php

use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;

/* @var $this yii\web\View */

$this->title = 'Файловый менеджер';

echo ElFinder::widget([
    'language'         => 'en',
    'controller'       => 'elfinder',
    'filter'           => false,
    'containerOptions' =>
        [
            'style' => 'width: 100%; height: 500px;'
        ],
    'callbackFunction' => new JsExpression('function(file, 1){}') // id - id виджета
]);
?>



