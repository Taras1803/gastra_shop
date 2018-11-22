<?php

namespace frontend\components;

use common\models\Categories;
use common\models\CategoriesDescriptions;
use common\models\Currency;
use common\models\Lang;
use common\models\Options;
use common\models\PagesContent;
use common\models\Products;
use common\models\ProductsAttributes;
use common\models\ProductsAttributesValues;
use common\models\ProductsToAttributes;
use common\models\ProductsToCategories;
use common\models\ThemeVariables;
use common\models\UserBasket;
use common\models\UserWishlist;
use Yii;
use yii\data\Pagination;
use yii\db\Expression;
use yii\db\Query;

class CatalogHelper
{
    static function getAllCatalogData()
    {
        $data = [];

        $data['min_price'] = Yii::$app->request->get('min_price', '');
        $data['max_price'] = Yii::$app->request->get('max_price', '');
        $data['order_by'] = Yii::$app->request->get('order_by', 'new');
        $data['currency'] = Currency::getCurrent()['symbol'];
        $data['filters'] = self::getFilters();
        $data['category'] = [
            'title' => Yii::t('main', 'catalog'),
            'slug' => 'all',
            'image' =>  ThemeVariables::getValueBySlug('catalog_all'),
            'description' => PagesContent::getPagesContentBySlug('page_catalog_description'),
            'category_id' => 0,
        ];

        $data['max_product_price'] = ceil(Products::find()
            ->max('price'));
        $data['products'] = [];


        $query = Products::find()
            ->where(['sm_products.status' => 1]);

        if ($data['order_by'] == 'action')
            $query = $query->andWhere(['>', 'sm_products.action', 0]);

        if ($data['min_price']) {
            $query = $query->andWhere(['>=', 'sm_products.price', (int)$data['min_price']]);
        }

        if ($data['max_price']) {
            $max_price = (int)$data['max_price'];
            if ($data['min_price'] && ($max_price <= (int)$data['min_price'])) {
                $max_price = (int)$data['min_price'] + 1;
                $data['max_price'] = $max_price;
            }

            $query = $query->andWhere(['<=', 'sm_products.price', $max_price]);
        }

        $pagination = new Pagination([
            'defaultPageSize' => Options::getBySlug('productPerPage'),
            'totalCount' => $query->count() // ...
        ]);

        if ($pagination->totalCount) {
            $data['products'] = $query
                ->orderBy(self::getFiltersSql($data['order_by']))
                ->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        }

        $data['pagination'] = $pagination;


        return $data;
    }

    static function getCatalogData($slug)
    {
        $data = [];
        if (Yii::$app->request->get('cats')) {
            $children_categories = explode(',', Yii::$app->request->get('cats', ''));
        }

        $category = Categories::findOne(['slug' => $slug]);
        if ($category) {
            $data['min_price'] = Yii::$app->request->get('min_price', '');
            $data['cats'] = $children_categories;
            $data['filters_cats'] = (Yii::$app->request->get('cats', '')) ? explode(',', Yii::$app->request->get('cats')) : '';
            $data['max_price'] = Yii::$app->request->get('max_price', '');
            $data['order_by'] = Yii::$app->request->get('order_by', 'new');
            $data['filters'] = self::getFilters();
            $data['max_product_price'] = ceil(Products::find()
                ->leftJoin('sm_products_to_categories', '`sm_products`.`id` = `sm_products_to_categories`.`product_id`')
                ->where(['sm_products.status' => 1])
                ->andWhere(['sm_products_to_categories.category_id' => $category->id])
                ->max('price'));
            $data['products'] = [];

            $description = $category->getCategoriesDescriptions()->one();
            $data['category'] = [
                'title' => $description->name,
                'slug' => $category->slug,
                'image' => $category->image,
                'description' => $description->description,
                'meta_title' => $description->meta_title,
                'meta_description' => $description->meta_description,
                'meta_keywords' => $description->meta_keywords,
                'category_id' => $category->id,
            ];

            $data['sub_categories'] = [];
            $sub_categories = Categories::findAll(['status' => 1, 'parent' => $category->id]);
            if ($sub_categories) {
                $cats = [];
                foreach ($sub_categories as $sub_cat) {
                    $description = $sub_cat->getCategoriesDescriptions()->one();
                    $cats[] = [
                        'id' => $sub_cat->id,
                        'title' => $description->name,
                        'slug' => $sub_cat->slug,
                    ];
                }
                $data['sub_categories'] = $cats;
            }

            $query = Products::find()
                ->leftJoin('sm_products_to_categories', '`sm_products`.`id` = `sm_products_to_categories`.`product_id`')
                ->where(['sm_products.status' => 1]);
            if ($data['order_by'] == 'action')
                $query = $query->andWhere(['>', 'sm_products.action', 0]);

            if ($children_categories) {
                $query = $query->andWhere(['in', 'sm_products_to_categories.category_id', $children_categories]);

            } else {
                $query = $query->andWhere(['sm_products_to_categories.category_id' => $category->id]);

            }

            if ($data['min_price']) {
                $query = $query->andWhere(['>=', 'sm_products.price', (int)$data['min_price']]);
            }

            if ($data['max_price']) {
                $max_price = (int)$data['max_price'];
                if ($data['min_price'] && ($max_price <= (int)$data['min_price'])) {
                    $max_price = (int)$data['min_price'] + 1;
                    $data['max_price'] = $max_price;
                }

                $query = $query->andWhere(['<=', 'sm_products.price', $max_price]);
            }

            $pagination = new Pagination([
                'defaultPageSize' => Options::getBySlug('productPerPage'),
                'totalCount' => $query->count() // ...
            ]);

            if ($pagination->totalCount) {
                $data['products'] = $query
                    ->orderBy(self::getFiltersSql($data['order_by']))
                    ->offset($pagination->offset)
                    ->limit($pagination->limit)
                    ->all();
            }
            $data['pagination'] = $pagination;
        }
        if ($data['filters_cats']){
            foreach ($data['sub_categories'] as $category){
                if ($category['id'] == $data['filters_cats'][0]){
                    $data['subCategoryCheckName'] = $category['title'];
                }
            }
        }
        return $data;
    }

    static function getCategoryData($main, $slug)
    {
        $data = [];

        $category = Categories::findOne(['slug' => $slug]);
        if ($category) {
            $lang = Lang::getCurrent();
            $data['min_price'] = Yii::$app->request->get('min_price', '');
            $data['max_price'] = Yii::$app->request->get('max_price', '');
            $data['order_by'] = Yii::$app->request->get('order_by', 'new');
            $data['currency'] = Currency::getCurrent()['symbol'];
            $data['filters'] = self::getFilters();
            $data['max_product_price'] = ceil(Products::find()
                ->leftJoin('sm_products_to_categories', '`sm_products`.`id` = `sm_products_to_categories`.`product_id`')
                ->where(['sm_products.status' => 1])
                ->andWhere(['sm_products_to_categories.category_id' => $category->id])
                ->max('price'));
            $data['products'] = [];
            $parent = CategoriesDescriptions::find()
                ->leftJoin('sm_categories', '`sm_categories`.`id` = `sm_categories_descriptions`.`parent_id`')
                ->where(['sm_categories_descriptions.lang_id' => $lang->id])
                ->andWhere(['sm_categories.status' => 1])
                ->andWhere(['sm_categories.slug' => $main])
                ->one();

            if (!$parent)
                return [];

            $description = $category->getCategoriesDescriptions()->one();
            $data['category'] = [
                'title' => $description->name,
                'slug' => $category->slug,
                'description' => $description->description,
                'meta_title' => $description->meta_title,
                'meta_description' => $description->meta_description,
                'meta_keywords' => $description->meta_keywords,
                'parent' => $main,
                'parent_title' => $parent->name,
                'category_id' => $category->id,
            ];

            $query = Products::find()
                ->leftJoin('sm_products_to_categories', '`sm_products`.`id` = `sm_products_to_categories`.`product_id`')
                ->where(['sm_products.status' => 1]);

            if ($data['order_by'] == 'action')
                $query = $query->andWhere(['>', 'sm_products.action', 0]);

            $query = $query->andWhere(['sm_products_to_categories.category_id' => $category->id]);

            if ($data['min_price']) {
                $query = $query->andWhere(['>=', 'sm_products.price', (int)$data['min_price']]);
            }

            if ($data['max_price']) {
                $max_price = (int)$data['max_price'];
                if ($data['min_price'] && ($max_price <= (int)$data['min_price'])) {
                    $max_price = (int)$data['min_price'] + 1;
                    $data['max_price'] = $max_price;
                }

                $query = $query->andWhere(['<=', 'sm_products.price', $max_price]);
            }

            $pagination = new Pagination([
                'defaultPageSize' => Options::getBySlug('productPerPage'),
                'totalCount' => $query->count() // ...
            ]);

            if ($pagination->totalCount) {
                $data['products'] = $query
                    ->orderBy(self::getFiltersSql($data['order_by']))
                    ->offset($pagination->offset)
                    ->limit($pagination->limit)
                    ->all();
            }
            $data['pagination'] = $pagination;
        }

        return $data;
    }

    static function getSingleProductAttributes($product_id)
    {
        $values = [];
        $lang = Lang::getCurrent();
        $product_to_attributes = ProductsToAttributes::find()->where(['product_id' => $product_id])->orderBy(['attribute_id' => SORT_DESC])->all();
        foreach ($product_to_attributes as $attribute) {
            $attribute_name = ProductsAttributes::findOne(['id' => $attribute->attribute_id]);
            $attribute_value = ProductsAttributesValues::findOne(['id' => $attribute->attribute_value_id]);
            if ($attribute_name && $attribute_value) {
                ProductsAttributesValues::findOne(['id' => $attribute->attribute_value_id]);
                if (isset($values[$attribute->attribute_id])) {
                    $values[$attribute->attribute_id]['value'] .= ',' . $attribute_value->value . " " . $attribute_value->{$lang->url};
                } else {
                    if ($attribute_name->id == 1 ){
                        $values[$attribute->attribute_id] = [
                            'attribute_name' => $attribute_name->{$lang->url},
                            'id' => $attribute_name->id,
                            'value' => $attribute_value->value . " " . $attribute_value->{$lang->url},
                        ];
                    }else{
                        $values[$attribute->attribute_id] = [
                            'attribute_name' => $attribute_name->{$lang->url},
                            'id' => $attribute_name->id,
                            'value' => $attribute_value->value,
                        ];
                    }

                }
            }
        }
        return $values;
    }


    static function getProductData($slug)
    {
        $data = [];
        $product = Products::findOne(['slug' => $slug, 'status' => 1]);
        if ($product) {
            $description = $product->getProductsDescriptions()->one();
            if ($description->consist != '') {
                $consist = explode(PHP_EOL, $description->consist);
            }
            $product_attributes = self::getSingleProductAttributes($product->id);
            foreach ($product_attributes as $attr_key => $attribute) {
                if ($attribute['id'] == 1) {
                    unset($product_attributes[$attr_key]);
                }
            }

            $lang = Lang::getCurrent();
            $data = [
                'id' => $product->id,
                'images' => $product->images,
                'price' => ThemeHelper::priceCalculation($product->price, 0),
                'action' => ($product->action) ? ThemeHelper::priceCalculation($product->price, $product->action) : 0,
                'article' => $product->article,
                'product_attributes' => $product_attributes,
                'lang' => $lang->url,
                'consist' => $consist,
                'title' => $description->title,
                'meta_title' => $description->meta_title,
                'meta_description' => $description->meta_description,
                'meta_keywords' => $description->meta_keywords,
                'slug' => $product->slug,
                'currency' => ThemeHelper::getCurrency(),
                'type' => self::getProductTypes($product->type),
                'type_item' => $product->type,
                'product_count' => self::getProductCount($product->id, $product->type),
                'description' => $description->description,
                'inWishlist' => UserWishlist::productInWishlist($product->id),
            ];
        }
        return $data;
    }

    static function getLastViewedProducts($slug)
    {
        $product = Products::findOne(['slug' => $slug]);
        $session = Yii::$app->session;
        if (!$session['user_last_viewed']) {
            $session['user_last_viewed'] = [];
        }
        $data = $session['user_last_viewed'];
        if (!in_array($product->id, $data)) {
            array_unshift($data, $product->id);
            $session['user_last_viewed'] = $data;
        } else {
            unset($data[array_search($product->id, $data)]);
            array_unshift($data, $product->id);
            $session['user_last_viewed'] = $data;
        }
        $ids = $session['user_last_viewed'];

        if (count($ids) >= 5) {
            array_splice($ids, 5);
            unset($session['user_last_viewed']);
            $session['user_last_viewed'] = $ids;
        }
        array_shift($ids);
        if ($ids) {
            foreach ($ids as $id) {
                $products[] = Products::findOne(['id' => $id]);
            }
        }
        return $products;
    }

    static function getRelatedProducts($slug)
    {
        $product = Products::findOne(['slug' => $slug]);
        $product_to_category = ProductsToCategories::find()->select('category_id')->where(['product_id' => $product->id])->one();
        $category_id = $product_to_category->category_id;
        $products_ids = ProductsToCategories::find()->select('product_id')->where(['category_id' => $category_id])->asArray()->column();
        if ($products_ids) {
            foreach ($products_ids as $id) {
                if ($id != $product->id) {
                    $ids[] = $id;
                }
            }
            if ($ids) {
                shuffle($ids);
                if (count($ids) > 4) {
                    array_splice($ids, 4);
                }
                $products = Products::find()->where(['in', 'id', $ids])->orderBy(new Expression('rand()'))->all();
            }
            return $products;
        }
        return '';
    }

    static function getProductCount($id, $type)
    {
        $lang = Lang::getCurrent();
        $data = [];
        if ($type == 1) {
            for ($i = 1; $i <= 5; $i++) {
                $data[$i] = vsprintf('%s %s', [$i, Yii::t('main', 'pc')]);
            }
        } else {
            $data[1] = vsprintf('%s %s', [50, Yii::t('main', 'gr')]);
            $query = new Query();
            $query->select(['sm_products_to_attributes.id AS id', 'sm_products_attributes_values.value AS value', 'sm_products_attributes_values.' . $lang->url . ' AS attr'])
                ->from('sm_products_to_attributes')
                ->leftJoin('sm_products_attributes_values', 'sm_products_to_attributes.attribute_value_id = sm_products_attributes_values.id')
                ->andWhere(['sm_products_to_attributes.product_id' => $id])
                ->andWhere(['sm_products_to_attributes.attribute_id' => 1])
                ->orderBy(['sm_products_to_attributes.sort' => SORT_ASC]);

            $command = $query->createCommand();
            $pta = $command->queryAll();
            if ($pta) {
                foreach ($pta as $item)
                    $data[$item['id']] = vsprintf('%s %s', [$item['value'], $item['attr']]);
            }
        }

        return $data;
    }

    static function getSearchProducts($q)
    {
        $data = [];
        $data['min_price'] = Yii::$app->request->get('min_price', '');
        $data['max_price'] = Yii::$app->request->get('max_price', '');
        $data['order_by'] = Yii::$app->request->get('order_by', 'new');
        $data['currency'] = ThemeHelper::getCurrency();
        $data['filters'] = self::getFilters();
        $data['max_product_price'] = Products::find()->max('price');

        $lang = Lang::getCurrent();

        $query = Products::find()
            ->leftJoin('sm_products_descriptions', '`sm_products`.`id` = `sm_products_descriptions`.`parent_id`')
            ->where(['sm_products_descriptions.lang_id' => $lang->id])
            ->andWhere(['sm_products.status' => 1])
            ->andFilterWhere(['LIKE', 'sm_products_descriptions.title', $q])
            ->orFilterWhere(['LIKE', 'sm_products_descriptions.description', $q]);

        if ($data['order_by'] == 'action')
            $query = $query->andWhere(['>', 'sm_products.action', 0]);

        if ($data['min_price']) {
            $query = $query->andWhere(['>=', 'sm_products.price', (int)$data['min_price']]);
        }

        if ($data['max_price']) {
            $max_price = (int)$data['max_price'];
            if ($data['min_price'] && ($max_price <= (int)$data['min_price'])) {
                $max_price = (int)$data['min_price'] + 1;
                $data['max_price'] = $max_price;
            }

            $query = $query->andWhere(['<=', 'sm_products.price', $max_price]);
        }

        $pagination = new Pagination([
            'defaultPageSize' => Options::getBySlug('productPerPage'),
            'totalCount' => $query->count() // ...
        ]);

        if ($pagination->totalCount) {
            $data['products'] = $query
                ->orderBy(self::getFiltersSql($data['order_by']))
                ->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        }

        $data['pagination'] = $pagination;
        return $data;
    }

    private static function getProductTypes($type)
    {
        $data = [
            1 => '1' . Yii::t('main', 'pc'),
            2 => '50' . Yii::t('main', 'gr'),
        ];

        return $data[$type];
    }

    private static function getFilters()
    {
        return [
            'new' => Yii::t('main', 'filter_new'),
            'action' => Yii::t('main', 'action'),
            'old' => Yii::t('main', 'filter_old'),
            'price_low' => Yii::t('main', 'filter_price_low'),
            'price_height' => Yii::t('main', 'filter_price_height'),
        ];
    }

    private static function getFiltersSql($slug)
    {
        $data = [
            'action' => '`sm_products`.`id` DESC',
            'new' => '`sm_products`.`id` DESC',
            'old' => '`sm_products`.`id` ASC',
            'price_height' => '`sm_products`.`action_price` DESC',
            'price_low' => '`sm_products`.`action_price` ASC',
        ];

        return $data[$slug];
    }

}
