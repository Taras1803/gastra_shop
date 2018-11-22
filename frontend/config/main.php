<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

return [
    'id' => $params['projectName'] . '-frontend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'account' => [
            'class' => 'frontend\modules\account\Account',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => ''
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => $params['projectName'] . '-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'class'=>'frontend\components\LangUrlManager',
            'rules'=>[
                '/' => 'site/index',
                '/catalog/<main:\w+>' => 'catalog/index',
                '/catalog/<main:\w+>/<slug:\w+>' => 'catalog/category',
                '/product/<slug:\w+>' => 'catalog/product',
                'search' => 'catalog/search',
                '<action>' => 'site/<action>',
                'account/<action>' => 'account/default/<action>',
                [
                    'pattern' => 'blog/<slug:\w+>',
                    'route' => 'blog/single',
                ],
                '<controller:\w+>/<action:\w+>/' => '<controller>/<action>'
            ]
        ]
    ],
    'params' => $params,
];
