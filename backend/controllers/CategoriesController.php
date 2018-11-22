<?php

namespace backend\controllers;

use backend\components\FileUploader;
use backend\models\CategoriesSearch;
use Yii;
use common\models\Categories;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\CategoriesDescriptions;
use common\models\Lang;
use common\models\ProductsToCategories;

/**
 * CategoriesController implements the CRUD actions for Categories model.
 */
class CategoriesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Categories models.
     * @return mixed
     */
    public function actionIndex()
    {
        $parent_id = Yii::$app->request->get('parent_id', 0);
        $categories = [];
        if(!$parent_id){
            $items = Categories::findAll(['parent' => 0]);
            if($items)
                foreach ($items as $item){
                    $categories[] = [
                        'data' => $item,
                        'description' => $item->getCategoriesDescriptions()->one(),
                        'countChild' => Categories::find()->where(['parent' => $item->id])->count(),
                        'countProducts' => ProductsToCategories::find()->where(['category_id' => $item->id])->count()
                    ];
                }
        } else {
            $items = Categories::findAll(['parent' => $parent_id]);
            if($items)
                foreach ($items as $item){
                    $categories[] = [
                        'data' => $item,
                        'description' => $item->getCategoriesDescriptions()->one(),
                        'countChild' => Categories::find()->where(['parent' => $item->id])->count(),
                        'countProducts' => ProductsToCategories::find()->where(['category_id' => $item->id])->count()
                    ];
                }
        }

        $prev = 0;
        if($categories)
            $prev = Categories::findOne(['id' => $categories[0]['data']->parent])->parent;

        return $this->render('index', [
            'categories' => $categories,
            'prev' => $prev,
        ]);
    }

    /**
     * Displays a single Categories model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
            'langs' => Lang::find()->orderBy(['default' => SORT_DESC])->all(),
            'descriptions' => CategoriesDescriptions::find()->where(['parent_id' => $id])->orderBy(['id' => SORT_ASC])->all(),
        ]);
    }

    /**
     * Creates a new Categories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Categories();

        $langs = Lang::find()->orderBy(['default' => SORT_DESC])->all();
        $descriptions = [];
        foreach ($langs as $lang){
            $descriptions[$lang->id] = new CategoriesDescriptions();
            $descriptions[$lang->id]->parent_id = 0;
            $descriptions[$lang->id]->lang_id = $lang->id;
        }

        $post_data = Yii::$app->request->post();
        if ($model->load($post_data) && $model->save()) {
            $images = explode("|", $model->image);
            if($images)
                foreach ($images as $image)
                    FileUploader::uploadImage($image, 'categories/');

            foreach ($langs as $lang){
                $descriptions[$lang->id]->parent_id = $model->id;
                foreach ($post_data['CategoriesDescriptions' . $lang->id] as $key => $value){
                    $descriptions[$lang->id]->{$key}  = $value;
                }
                $descriptions[$lang->id]->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'langs' => $langs,
            'descriptions' => $descriptions,
            'parents' => Categories::getCategoriesParents(),
        ]);
    }

    /**
     * Updates an existing Categories model.
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
            $descriptions[$lang->id] = CategoriesDescriptions::findOne(['parent_id' => $id, 'lang_id' => $lang->id]);
        }

        $post_data = Yii::$app->request->post();
        if ($model->load($post_data) && $model->save()) {
            $images = explode("|", $model->image);
            if($images)
                foreach ($images as $image)
                    FileUploader::uploadImage($image, 'categories/');

            foreach ($langs as $lang){
                foreach ($post_data['CategoriesDescriptions' . $lang->id] as $key => $value){
                    $descriptions[$lang->id]->{$key}  = $value;
                }
                $descriptions[$lang->id]->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'langs' => $langs,
            'descriptions' => $descriptions,
            'parents' => Categories::getCategoriesParents(),
        ]);
    }

    /**
     * Deletes an existing Categories model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $images = $model->image;
        if($model->delete()){
            FileUploader::removeImage($images, 'banners/');
            CategoriesDescriptions::deleteAll(['parent_id' => $id]);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Categories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Categories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Categories::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
