<?php
namespace backend\models;

use Yii;
use yii\helpers\Url;


/**
 * Manager Roles
 */
class ManagerRoles
{
    static function roles()
    {
        return [
            '1' => 'Admin',
            '2' => 'Manager',
        ];
    }

    static function getRoleName($key)
    {
        return self::roles()[$key];
    }

    static function userCan($permission = 10){
        if(Yii::$app->user->isGuest)
            return Yii::$app->response->redirect('/');

        $role = Yii::$app->user->identity->role;
        if($role > $permission)
            return Yii::$app->response->redirect('/manager/');
    }

    static function menu($role = 1){
        if($role == 1)
            return self::menu_admin();
//        else
//            return self::manager();
    }

    private static function menu_admin(){
        return [
            ['label' => 'Главная', 'icon' => ' fa-dashboard', 'url' => Url::to('/manager/'), 'route' => 'site/index'],
            ['label' => 'Пользователи', 'icon' => ' fa-users', 'url' => Url::to('/manager/user/'), 'route' => 'user/index'],
            [
                'label' => 'Продажи',
                'icon' => 'money',
                'url' => '#',
                'items' => [
                    ['label' => 'Заказы', 'icon' => 'circle-o', 'url' => Url::to('/manager/orders/'), 'route' => 'orders/index'],
                    ['label' => 'Статусы заказов', 'icon' => 'circle-o', 'url' => Url::to('/manager/orders-status/'), 'route' => 'orders-status/index'],
                    ['label' => 'Способы доставки', 'icon' => 'circle-o', 'url' => Url::to('/manager/delivery-methods/'), 'route' => 'delivery-methods/index'],
                    ['label' => 'Промокод', 'icon' => 'circle-o', 'url' => Url::to('/manager/promo-codes/'), 'route' => 'promo-codes/index'],
                ],
            ],
            [
                'label' => 'Каталог',
                'icon' => 'archive',
                'url' => '#',
                'items' => [
                    ['label' => 'Категории', 'icon' => 'circle-o', 'url' => Url::to('/manager/categories/'), 'route' => 'categories/index'],
                    ['label' => 'Товары', 'icon' => 'circle-o', 'url' => Url::to('/manager/products/'), 'route' => 'products/index'],
                    ['label' => 'Атрибуты товаров', 'icon' => 'circle-o', 'url' => Url::to('/manager/products-attributes/'), 'route' => 'products-attributes/index'],
                ],
            ],
            ['label' => 'Новости', 'icon' => ' fa-newspaper-o', 'url' => Url::to('/manager/news/'), 'route' => 'news/index'],
            [
                'label' => 'Настройки темы',
                'icon' => 'pencil-square-o',
                'url' => '#',
                'items' => [
                    ['label' => 'Контент страниц', 'icon' => 'circle-o', 'url' => Url::to('/manager/pages-content/'), 'route' => 'pages-content/index'],
                    ['label' => 'Опции темы', 'icon' => 'circle-o', 'url' => Url::to('/manager/pages-content/theme-variables'), 'route' => 'pages-content/theme-variables'],
                    ['label' => 'Главный Банер', 'icon' => 'circle-o', 'url' => Url::to('/manager/banner/'), 'route' => 'banner/index'],
                    ['label' => 'Настройки SEO', 'icon' => 'circle-o', 'url' => Url::to('/manager/seo/'), 'route' => 'seo/index'],
                    ['label' => 'Валюты', 'icon' => 'circle-o', 'url' => Url::to('/manager/currency/'), 'route' => 'currency/index'],
                ],
            ],
            [
                'label' => 'Настройки проекта',
                'icon' => 'cog',
                'url' => '#',
                'items' => [
                    ['label' => 'Опции', 'icon' => 'circle-o', 'url' => Url::to('/manager/options'), 'route' => 'site/options'],
                    ['label' => 'Adminer', 'icon' => 'circle-o', 'url' => Url::to('/manager/adminer.php'), 'route' => ''],
                    ['label' => 'Файловый менеджер', 'icon' => 'circle-o', 'url' => Url::to('/manager/file-manager'), 'route' => 'site/file-manager'],
//                    ['label' => 'Менеджеры', 'icon' => 'circle-o', 'url' => Url::to('/manager/managers'), 'route' => 'site/managers'],
                ],
            ]
        ];
    }

}
