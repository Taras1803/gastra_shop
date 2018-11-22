<?php

namespace common\models;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "{{%user_wishlist}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $created_at
 */
class UserWishlist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_wishlist}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at'], 'required'],
            [['user_id', 'product_id', 'created_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
            'created_at' => 'Дата создания',
        ];
    }

    static function getUserProductsIds()
    {
        if (Yii::$app->user->isGuest) {
            $productsIds = Yii::$app->session->get('user_wishlist', []);
        } else {
            $productsIds = UserWishlist::find()->select(['product_id'])->where(['user_id' => Yii::$app->user->id])->column();
        }
        return $productsIds;
    }

    static function getDays($id)
    {
        $created_at = UserWishlist::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['product_id' => $id])->one()->created_at;
        $seconds = $created_at - time();
        $days = ceil($seconds / 86400);
        return $days;
    }


    static function getUserProducts()
    {
        if (Yii::$app->user->isGuest) {
            $productsIds = Yii::$app->session->get('user_wishlist', []);
            $query = Products::find()->where(['in', 'id', $productsIds]);
        } else {
            $query = Products::find()
                ->leftJoin('sm_user_wishlist', 'sm_user_wishlist.product_id = sm_products.id')
                ->where(['sm_user_wishlist.user_id' => Yii::$app->user->id]);
        }
        $pagination = new Pagination([
            'defaultPageSize' => Options::getBySlug('productPerPage'),
            'totalCount' => $query->count()
        ]);
        $data['products'] = $query->offset($pagination->offset)->limit($pagination->limit)->all();
        $data['pagination'] = $pagination;
        return $data;
    }

    static function getProductCount()
    {
        if (Yii::$app->user->isGuest) {
            $products = Yii::$app->session->get('user_wishlist', []);
        } else {
            $products = UserWishlist::findAll(['user_id' => Yii::$app->user->id]);
        }
        return count($products);
    }

    static function addProduct($id)
    {
        $json = [];
        $json['error'] = 0;
        $json['user_wishlist_count'] = 0;
        if (Yii::$app->user->isGuest) {
            $products = Yii::$app->session->get('user_wishlist', []);
            $products[$id] = $id;
            Yii::$app->session->set('user_wishlist', $products);
            $json['user_wishlist_count'] = self::getProductCount();
            $json['error'] = 1;
            $json['action'] = 'add';
        } else {
            $userWishlist = new UserWishlist;
            $userWishlist->user_id = Yii::$app->user->id;
            $userWishlist->product_id = $id;
            $userWishlist->created_at = time() + 2543343;
            $userWishlist->save();
            $json['user_wishlist_count'] = self::getProductCount();
            $json['error'] = 1;
            $json['action'] = 'add';
        }
        return $json;
    }

    static function removeProduct($id)
    {
        $json = [];
        $json['error'] = 0;
        $json['user_wishlist_count'] = 0;
        if (Yii::$app->user->isGuest) {
            $products = Yii::$app->session->get('user_wishlist', []);
            unset($products[$id]);
            Yii::$app->session->set('user_wishlist', $products);
            $json['user_wishlist_count'] = self::getProductCount();
            $json['error'] = 1;
            $json['action'] = 'remove';
        } else {
            $product = UserWishlist::find()->where(['product_id' => $id])->andWhere(['user_id' => Yii::$app->user->id])->one();
            $product->delete();
            $json['user_wishlist_count'] = self::getProductCount();
            $json['error'] = 1;
            $json['action'] = 'remove';
        }
        return $json;
    }

    static function productInWishlist($productID)
    {
        if(Yii::$app->user->isGuest){
            $productsIds = Yii::$app->session->get('user_wishlist', []);
            if($productsIds && isset($productsIds[$productID]))
                return true;
            else
                return false;
        } else {
            $count = Products::find()
                ->leftJoin('sm_user_wishlist', 'sm_user_wishlist.product_id = sm_products.id')
                ->where(['sm_user_wishlist.user_id' => Yii::$app->user->id])
                ->andWhere(['sm_user_wishlist.product_id' => $productID])
                ->andWhere(['sm_products.status' => 1])
                ->count();
            if($count)
                return true;
            else
                return false;
        }
    }
}
