<?php

namespace backend\controllers;

use common\models\ProductsToAttributes;
use Yii;
use common\models\Products;
use backend\models\ProductsSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\components\FileUploader;
use common\models\Categories;
use common\models\Lang;
use common\models\ProductsAttributes;
use common\models\ProductsAttributesValues;
use common\models\ProductsDescriptions;
use common\models\ProductsToCategories;


/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'langs' => Lang::find()->orderBy(['default' => SORT_DESC])->all(),
            'descriptions' => ProductsDescriptions::find()->where(['parent_id' => $id])->orderBy(['id' => SORT_ASC])->all(),
            'categories' => Categories::getCategoriesParents(),
            'productToCategory' => ProductsToCategories::findAll(['product_id' => $id]),
            'attributes' => ArrayHelper::map(ProductsAttributes::find()->all(), 'id', 'ru'),
            'productToAttributes' => ProductsToAttributes::getProductAttributes($id),
        ]);
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Products();
        $langs = Lang::find()->orderBy(['default' => SORT_DESC])->all();
        $descriptions = [];
        foreach ($langs as $lang) {
            $descriptions[$lang->id] = new ProductsDescriptions();
            $descriptions[$lang->id]->parent_id = 0;
            $descriptions[$lang->id]->lang_id = $lang->id;
        }

        $post_data = Yii::$app->request->post();
        if($post_data){
            $model->action_price = $post_data['Products']['price'];
            if($post_data['Products']['action'])
                $model->action_price = $post_data['Products']['price'] - ($post_data['Products']['price'] / 100 * $post_data['Products']['action']);
        }

        $model->created_at = time();
        $model->updated_at = time();

        if ($model->load($post_data) && $model->save()) {
            $images = explode("|", $model->images);

            if ($images)
                foreach ($images as $image)
                    FileUploader::uploadImage($image, 'products/');

            foreach ($langs as $lang) {
                $descriptions[$lang->id]->parent_id = $model->id;
                foreach ($post_data['ProductsDescriptions' . $lang->id] as $key => $value) {
                    $descriptions[$lang->id]->{$key} = $value;
                }
                $descriptions[$lang->id]->save();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
            'langs' => $langs,
            'descriptions' => $descriptions,
        ]);
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $langs = Lang::find()->orderBy(['default' => SORT_DESC])->all();
        $descriptions = [];
        foreach ($langs as $lang){
            $descriptions[$lang->id] = ProductsDescriptions::findOne(['parent_id' => $id, 'lang_id' => $lang->id]);
        }

        $post_data = Yii::$app->request->post();
        $model->updated_at = time();


        if($post_data){
            $model->action_price = $post_data['Products']['price'];
            if($post_data['Products']['action'])
                $model->action_price = $post_data['Products']['price'] - ($post_data['Products']['price'] / 100 * $post_data['Products']['action']);
        }

        if ($model->load($post_data) && $model->save()) {
            $images = explode("|", $model->images);
            if($images)
                foreach ($images as $image)
                    FileUploader::uploadImage($image, 'products/');

            foreach ($langs as $lang){
                foreach ($post_data['ProductsDescriptions' . $lang->id] as $key => $value){
                    $descriptions[$lang->id]->{$key}  = $value;
                }
                $descriptions[$lang->id];
                $descriptions[$lang->id]->save();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'langs' => $langs,
            'descriptions' => $descriptions,
        ]);
    }

    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $images = $model->images;
        if($model->delete()){
            FileUploader::removeImage($images, 'products/');
            ProductsDescriptions::deleteAll(['parent_id' => $id]);
            ProductsToCategories::deleteAll(['product_id' => $id]);
        }

        return $this->redirect(['index']);
    }

    public function actionSaveProductToCategory()
    {
        $data = Yii::$app->request->post();
        if(!$data)
            return $this->redirect(['index']);

        if($data['id'] == 0)
            $value = new ProductsToCategories();
        else
            $value = ProductsToCategories::findOne($data['id']);

        $value->product_id = (int)$data['product_id'];
        $value->category_id = (int)$data['item']['category_id'];
        $value->save();
    }

    public function actionRemoveProductToCategory()
    {
        $data = Yii::$app->request->post();
        if(!$data)
            return $this->redirect(['index']);

        header('Content-Type: text/html; charset=utf-8');
        ob_start();
        if(ProductsToCategories::findOne($data['id'])->delete())
            echo 'done';
        ob_end_flush();
        die;
    }

    public function actionGetAttributeValues()
    {
        $data = Yii::$app->request->post();
        if(!$data)
            return $this->redirect(['index']);

        $values = ProductsAttributesValues::findAll(['product_attributes_id' => $data['val']]);
        header('Content-Type: text/html; charset=utf-8');
        ob_start();
        if($values)
            foreach ($values as $value)
                echo '<option value="' . $value->id . '">' . $value->value . ' (' . $value->ru . ')' . '</option>';
        ob_end_flush();
        die;
    }

    public function actionSaveProductToAttribute()
    {
        $data = Yii::$app->request->post();
        if(!$data)
            return $this->redirect(['index']);

        if($data['id'] == 0)
            $value = new ProductsToAttributes();
        else
            $value = ProductsToAttributes::findOne($data['id']);

        $value->product_id = (int)$data['product_id'];
        $value->attribute_id = (int)$data['item']['attribute_id'];
        $value->attribute_value_id = (int)$data['item']['attribute_value_id'];
        $value->price = (int)$data['item']['price'];
        $value->sort = (int)$data['item']['sort'];
        $value->save();
    }

    public function actionRemoveProductToAttribute()
    {
        $data = Yii::$app->request->post();
        if(!$data)
            return $this->redirect(['index']);

        header('Content-Type: text/html; charset=utf-8');
        ob_start();
        if(ProductsToAttributes::findOne($data['id'])->delete())
            echo 'done';
        ob_end_flush();
        die;
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
