<?php

namespace backend\controllers;

use Yii;
use common\models\Banner;
use backend\models\BannerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Lang;
use backend\components\FileUploader;
use common\models\BannerDescription;

/**
 * BannerController implements the CRUD actions for Banner model.
 */
class BannerController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all Banner models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BannerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Banner model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'langs' => Lang::find()->orderBy(['default' => SORT_DESC])->all(),
            'descriptions' => BannerDescription::find()->where(['parent_id' => $id])->orderBy(['id' => SORT_ASC])->all()
        ]);
    }

    /**
     * Creates a new Banner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Banner();
        $model->sort = 0;
        $langs = Lang::find()->orderBy(['default' => SORT_DESC])->all();
        $descriptions = [];
        foreach ($langs as $lang){
            $descriptions[$lang->id] = new BannerDescription();
            $descriptions[$lang->id]->parent_id = 0;
            $descriptions[$lang->id]->lang_id = $lang->id;
        }

        $post_data = Yii::$app->request->post();

        if ($model->load($post_data) && $model->save()) {
            $images = explode("|", $model->image);
            if($images)
                foreach ($images as $image)
                    FileUploader::uploadImage($image, 'banners/');

            foreach ($langs as $lang){
                $descriptions[$lang->id]->parent_id = $model->id;
                foreach ($post_data['BannerDescription' . $lang->id] as $key => $value){
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
        ]);
    }

    /**
     * Updates an existing Banner model.
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
            $descriptions[$lang->id] = BannerDescription::findOne(['parent_id' => $id, 'lang_id' => $lang->id]);
        }

        $post_data = Yii::$app->request->post();
        if ($model->load($post_data) && $model->save()) {
            $images = explode("|", $model->image);
            if($images)
                foreach ($images as $image)
                    FileUploader::uploadImage($image, 'banners/');

            foreach ($langs as $lang){
                foreach ($post_data['BannerDescription' . $lang->id] as $key => $value){
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
     * Deletes an existing Banner model.
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
            BannerDescription::deleteAll(['parent_id' => $id]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Banner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Banner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Banner::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
