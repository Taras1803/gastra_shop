<?php

namespace frontend\widgets;

use common\models\Currency;
use common\models\UserWishlist;
use frontend\components\BasketHelper;
use yii;
use yii\helpers\Url;
use common\models\Lang;
use common\models\ThemeVariables;
use common\models\Categories;

class Menu extends \yii\bootstrap\Widget
{
    public function run()
    {
        return $this->render('menu/view', [
            'currentLanguage' => Lang::getCurrent(),
            'currencyData' => [
                'list' => Currency::find()->all(),
                'current' => Currency::getCurrent(),
            ],
            'langs' => Lang::find()->orderBy(['default' => SORT_DESC])->all(),
            'theme_variables' => ThemeVariables::getValues(),
            'rightMenu' => $this->getRightMenu(),
            'mobileMenu' => $this->getMobileMenu(),
            'categories_menu' => $this->getCategoriesMenu(),
            'wishlistCount' => UserWishlist::getProductCount(),
            'basketCount' => BasketHelper::getBasketProductsCount(),
            'basketData' => BasketHelper::getBasketData(),
        ]);
    }

    private function getCategoriesMenu()
    {
        $data = [];
        $categories = Categories::findAll(['parent' => 0, 'status' => 1]);
        if ($categories) {
            foreach ($categories as $key => $category) {
                $sub_categories = Categories::findAll(['status' => 1, 'parent' => $category->id]);
                if ($sub_categories) {
                    $cats = [];
                    foreach ($sub_categories as  $sub_cat) {
                        $cats[] = [
                            'image' => $sub_cat->image,
                            'title' => ($sub_cat->getCategoriesDescriptions()->one())->name,
                            'link' => Url::to(['/catalog']) . '/' . $category->slug . '/' . $sub_cat->slug,
                        ];
                    }
                }
                $data[] = [
                    'image' => $category->image,
                    'title' => ($category->getCategoriesDescriptions()->one())->name,
                    'link' => Url::to(['/catalog']) . '/' . $category->slug,
                    'subCategories' => $cats,
                ];
                if ($category->slug == Yii::$app->request->get()['main']){
                    $data[$key]['active'] = true;
                }
            }
        }

        return $data;
    }

    private function getRightMenu()
    {
        return [
            [
                'title' => Yii::t('main', 'about_us'),
                'link' => Url::to(['/about-us']),
            ],
            [
                'title' => Yii::t('main', 'payment_delivery'),
                'link' => Url::to(['/payment-delivery']),
            ],
            [
                'title' => Yii::t('main', 'contacts'),
                'link' => Url::to(['/contacts']),
            ],
            [
                'title' => Yii::t('main', 'blog'),
                'link' => Url::to(['/blog']) . '/',
            ],
        ];
    }

    private function getMobileMenu()
    {
        return [
            [
                'title' => Yii::t('main', 'coffee'),
                'link' => '#',
            ],
            [
                'title' => Yii::t('main', 'coffee_accessories'),
                'link' => '#',
            ],
            [
                'title' => Yii::t('main', 'tea'),
                'link' => '#',
            ],
            [
                'title' => Yii::t('main', 'about_us'),
                'link' => Url::to(['/about-us']),
            ],
            [
                'title' => Yii::t('main', 'payment_delivery'),
                'link' => Url::to(['/payment-delivery']),
            ],
            [
                'title' => Yii::t('main', 'contacts'),
                'link' => Url::to(['/contacts']),
            ],
            [
                'title' => Yii::t('main', 'blog'),
                'link' => Url::to(['/blog']) . '/',
            ],
        ];
    }
}