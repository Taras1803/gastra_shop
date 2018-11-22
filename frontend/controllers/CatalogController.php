<?php

namespace frontend\controllers;

use common\models\Currency;
use common\models\Options;
use common\models\PagesContent;
use common\models\Products;
use common\models\Seo;
use common\models\ThemeVariables;
use common\models\UserWishlist;
use frontend\components\ThemeHelper;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use frontend\components\CatalogHelper;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class CatalogController extends Controller
{

    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    public function actionIndex()
    {
        $category_slug = Yii::$app->request->get('main', false);
        if (!$category_slug)
            throw new NotFoundHttpException();
        if ($category_slug == 'all') {
            $metaData = Seo::getDataBySlug('/catalog/all');
            Yii::$app->params['metaData'] = $metaData;
            $catalog_data = CatalogHelper::getAllCatalogData();

            if (!$catalog_data)
                throw new NotFoundHttpException();
        } else {
            $catalog_data = CatalogHelper::getCatalogData($category_slug);
            if (!$catalog_data)
                throw new NotFoundHttpException();

            $metaData = Seo::getDataBySlug();
            $metaData['meta_title'] = $catalog_data['category']['meta_title'];
            $metaData['meta_description'] = $catalog_data['category']['meta_description'];
            $metaData['meta_keywords'] = $catalog_data['category']['meta_keywords'];

            Yii::$app->params['metaData'] = $metaData;
        }
        return $this->render('index', [
            'catalog_data' => $catalog_data,
        ]);
    }

    public function actionCategory($main, $slug)
    {
        $catalog_data = CatalogHelper::getCategoryData($main, $slug);
        if (!$catalog_data)
            throw new NotFoundHttpException();

        $metaData = Seo::getDataBySlug();

        $metaData['meta_title'] = $catalog_data['category']['meta_title'];
        $metaData['meta_description'] = $catalog_data['category']['meta_description'];
        $metaData['meta_keywords'] = $catalog_data['category']['meta_keywords'];

        Yii::$app->params['metaData'] = $metaData;

        return $this->render('category', [
            'catalog_data' => $catalog_data,
        ]);
    }

    public function actionProduct($slug)
    {
        $product = CatalogHelper::getProductData($slug);
        if (!$product)
            throw new NotFoundHttpException();

        $metaData = Seo::getDataBySlug();
        $metaData['meta_title'] = $product['meta_title'];
        $metaData['meta_description'] = $product['meta_description'];
        $metaData['meta_keywords'] = $product['meta_keywords'];
        $metaData['meta_img'] = Yii::$app->glide->createSignedUrl([
            'glide/index',
            'path' => 'products/' . $product['images'],
            'w' => 570
        ], true);

        Yii::$app->params['metaData'] = $metaData;
        return $this->render('product', [
            'product' => $product,
            'currency' => Currency::getCurrent(),
            'last_products' => CatalogHelper::getLastViewedProducts($slug),
            'related_products' => CatalogHelper::getRelatedProducts($slug),
        ]);
    }

    public function actionSearch($q)
    {
        if (!$q || mb_strlen($q) < 2)
            throw new NotFoundHttpException();

        $metaData = Seo::getDataBySlug('/search');
        $metaData['meta_title'] .= ' ' . $q;

        Yii::$app->params['metaData'] = $metaData;

        $catalog_data = CatalogHelper::getSearchProducts($q);

        return $this->render('search', [
            'catalog_data' => $catalog_data,
            'q' => $q,
        ]);
    }

    public function actionWishlist()
    {
        $metaData = Seo::getDataBySlug('/catalog/wishlist');
        $products = UserWishlist::getUserProducts();
        Yii::$app->params['metaData'] = $metaData;
        return $this->render('wishlist', [
            'wishlistText' => PagesContent::getPagesContentBySlug('wishlist_text'),
            'products' => $products,
        ]);
    }
}
