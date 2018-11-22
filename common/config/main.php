<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'language'=>'ru-Ru',
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@frontend/languages',
                    'sourceLanguage' => 'ru',
                    'fileMap' => [
                        'main' => 'main.php',
                        'mail' => 'mail.php',
                    ],
                ],
            ],
        ],
        'glide' => [
            'class' => 'trntv\glide\components\Glide',
            'sourcePath' => '@storage/web/source',
            'cachePath' => '@storage/cache',
            'urlManager' => 'urlManagerStorage',
//            'signKey' => '9f2ec977e73828086088239e55036753'
        ],
        'urlManagerStorage' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => '/storage/web',
                'baseUrl' => 'https://gastrashop.com.ua/storage',
            ],
            require(Yii::getAlias('@storage/config/_urlManager.php'))
        )
    ],
];