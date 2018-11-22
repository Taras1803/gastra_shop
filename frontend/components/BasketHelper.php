<?php

namespace frontend\components;

use common\models\Options;
use Yii;
use common\models\UserBasket;
use yii\helpers\Url;
use common\models\Products;
use common\models\ProductsToAttributes;
use common\models\Currency;
use common\models\Lang;
use common\models\ProductsToLookbook;

class BasketHelper
{
    static function addProduct($data)
    {
        $json = [];
        $json['error'] = 0;
        $json['basket_count'] = 0;

        $product = Products::findOne(['id' => $data['id'], 'status' => 1]);
        if (!$product) {
            $json['error'] = 1;
            $json['basket_count'] = self::getBasketProductsCount();
            return $json;
        }

        if ($product->type == 2 && $data['count'] != 1) {
            $pta = ProductsToAttributes::findOne($data['count']);
            if (!$pta) {
                $json['error'] = 1;
                $json['basket_count'] = self::getBasketProductsCount();
                return $json;
            }
        }

        $product = [
            'id' => $data['id'],
            'count' => $data['count'],
        ];

        if (Yii::$app->user->isGuest)
            self::setGuestBasket($product);
        else
            self::setLoginBasket($product);

        $json['basket_count'] = self::getBasketProductsCount();
        $json['html'] = self::getBasketHtml();
        return $json;
    }

    static function changeProductCount($data)
    {
        $json = [];
        $json['error'] = 0;

        if (Yii::$app->user->isGuest) {

            $basket_data = self::getUserBasket();
            if (isset($basket_data[$data['key']]))
                $basket_data[$data['key']]['count'] = $data['count'];
            Yii::$app->session->set('userBasket', $basket_data);
        } else {
            $basket_data = self::getUserBasket();
            if (isset($basket_data[$data['key']]))
                $basket_data[$data['key']]['count'] = $data['count'];

            $ub = UserBasket::findOne(['user_id' => Yii::$app->user->id]);
            $ub->params = json_encode($basket_data);
            $ub->save();
        }

        return $json;
    }

    static function removeProduct($key)
    {
        $json = [];
        $json['error'] = 0;

        if (Yii::$app->user->isGuest) {
            $basket_data = self::getUserBasket();
            if (isset($basket_data[$key]))
                unset($basket_data[$key]);
            Yii::$app->session->set('userBasket', $basket_data);
        } else {
            $basket_data = self::getUserBasket();
            if (isset($basket_data[$key]))
                unset($basket_data[$key]);

            $ub = UserBasket::findOne(['user_id' => Yii::$app->user->id]);
            $ub->params = ($basket_data) ? json_encode($basket_data) : '';
            $ub->save();
        }
        return $json;
    }

    private static function setGuestBasket($product)
    {
        $basketData = self::getUserBasket();
        $basketData[$product['id']] = $product;

        Yii::$app->session->set('userBasket', $basketData);
    }

    private static function setLoginBasket($product)
    {
        $basket_data = self::getUserBasket();
        $basket_data[] = $product;
        $ub = UserBasket::findOne(['user_id' => Yii::$app->user->id]);
        if($ub){
            $ub->params = json_encode($basket_data);
            $ub->save();
        }
    }

    public static function getUserBasket()
    {
        if (Yii::$app->user->isGuest)

            return Yii::$app->session->get('userBasket', []);
        else {
            $ub = UserBasket::findOne(['user_id' => Yii::$app->user->id]);
            $basket = [];
            if (!$ub)
                return $basket;

            return json_decode($ub->params, true);
        }
    }

    public static function getBasketProductsCount()
    {
        return count(self::getUserBasket());
    }

    public static function clearUserBasket($user_id = 0)
    {
        if ($user_id > 0) {
            $ub = UserBasket::findOne(['user_id' => $user_id]);
            if ($ub) {
                $ub->params = '';
                $ub->save();
            }
        } else {
            if (Yii::$app->user->isGuest) {
                Yii::$app->session->remove('userBasket');
            } else {
                $ub = UserBasket::findOne(['user_id' => Yii::$app->user->id]);
                if ($ub) {
                    $ub->params = '';
                    $ub->save();
                }
            }
        }
    }

    public static function clearSessionBasket($key)
    {
        session_id($key);
        session_start();
        unset($_SESSION['userBasket']);
    }

    static function getBasketData()
    {
        $data = [];
        $userBasket = self::getUserBasket();
        if ($userBasket) {
            $data['products'] = [];
            $data['totals'] = 0;
            $data['products_count'] = 0;
            $data['currency'] = ThemeHelper::getCurrency();
            $data['defaultWeight'] = Options::getBySlug('defaultWeight');
            foreach ($userBasket as $key => $item) {
                $product = Products::findOne($item['id']);
                if ($product) {
                    $description = $product->getProductsDescriptions()->one();
                    if ($product->type == 1) {
                        $price = round($item['count'] * ThemeHelper::priceCalculation($product->price, $product->action), 2);
                    } else {
                        if ($item['count'] != 1) {
                            $pta = ProductsToAttributes::findOne($item['count']);
                            if ($pta)
                                $price = round(ThemeHelper::priceCalculation($pta->price, $product->action), 2);
                            else
                                $price = round($item['count'] * ThemeHelper::priceCalculation($product->price, $product->action), 2);
                        } else {
                            $price = round($item['count'] * ThemeHelper::priceCalculation($product->price, $product->action), 2);
                        }
                    }

                    $product_attributes = CatalogHelper::getSingleProductAttributes($product->id);

                    $data['totals'] += $price;
                    $counts = CatalogHelper::getProductCount($product->id, $product->type);
                    $data['products'][$key] = [
                        'id' => $product->id,
                        'slug' => $product->slug,
                        'type' => $product->type,
                        'action' => $product->action,
                        'price' => $price,
                        'article' => $product->article,
                        'title' => $description->title,
                        'image' => explode("|", $product->images)[0],
                        'attributes' => $product_attributes,
                        'count' => $item['count'],
                        'counts' => $counts
                    ];
                    $data['products_count'] += 1;
                }
            }
        }
//        print_r($data);
//        die();
        return $data;
    }

    static function getBasketHtml()
    {
        $basketData = self::getBasketData();
        $currency = Currency::getCurrent();
        $html = '';
        if ($basketData) {
            $productsHtml = '';
            foreach ($basketData['products'] as $key => $product) {
                $count_html = ($product['type'] == 1) ? Yii::t('main', 'quantity') : Yii::t('main', 'weight');
                $productsHtml .= '<div class="basket-drop__item"><div class="basket-drop__photo"><a href="' . Url::to(['/product/' . $product['slug']]) . '"><img src="' . Yii::$app->glide->createSignedUrl(['glide/index', 'path' => 'products/' . $product['image'], 'w' => 225], true) . '" alt="' . $product['title'] . '"></a></div><div class="basket-drop__description"><div class="basket-drop__type">' . $product['article'] . '</div><div class="basket-drop__name">' . $product['title'] . '</div><div class="basket-drop__inline"><div class="basket-drop__mass"><span class="basket-drop__value">' . $count_html . ': ' . $product['counts'][$product['count']] . '</span></div><div class="basket-drop__price">' . $product['price'] . $currency['symbol'] . '</div></div><button class="basket-drop__delete"  onclick="basket.remove(' . $key . ')">x</button></div></div>';
            }
            $html = '<div class="basket-drop__full"><div class="basket-drop__items scrollbar">' . $productsHtml . '</div><div class="basket-drop__bottom"><strong>' . Yii::t('main', 'total_cost') . ' <span>' . $basketData['totals'] . $currency['symbol'] . '</span></strong><a href="' . Url::to(['/checkout']) . '" class="btn-border btn-border--whith-arrow cf-arrow-right"><span>' . Yii::t('main', 'checkout_button') . '</span></a></div>';
        }

        return $html;
    }

}
