<?php

namespace backend\controllers;

use Yii;
use common\models\News;
use backend\models\NewsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Lang;
use common\models\NewsDescriptions;
use backend\components\FileUploader;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
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
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'langs' => Lang::find()->orderBy(['default' => SORT_DESC])->all(),
            'descriptions' => NewsDescriptions::find()->where(['parent_id' => $id])->orderBy(['id' => SORT_ASC])->all()
        ]);
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();

        $langs = Lang::find()->orderBy(['default' => SORT_DESC])->all();
        $descriptions = [];
        foreach ($langs as $lang) {
            $descriptions[$lang->id] = new NewsDescriptions();
            $descriptions[$lang->id]->parent_id = 0;
            $descriptions[$lang->id]->lang_id = $lang->id;
        }

        $post_data = Yii::$app->request->post();
        $model->created_at = time();
        $model->updated_at = time();
        if ($model->load($post_data) && $model->save()) {
            $images = explode("|", $model->images);
            if ($images)
                foreach ($images as $image)
                    FileUploader::uploadImage($image, 'blog/');

            foreach ($langs as $lang) {
                $descriptions[$lang->id]->parent_id = $model->id;
                foreach ($post_data['NewsDescriptions' . $lang->id] as $key => $value) {
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
     * Updates an existing News model.
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
        foreach ($langs as $lang) {
            $descriptions[$lang->id] = NewsDescriptions::findOne(['parent_id' => $id, 'lang_id' => $lang->id]);
        }

        $post_data = Yii::$app->request->post();
        $model->updated_at = time();
        if ($model->load($post_data) && $model->save()) {
            $images = explode("|", $model->images);
            if ($images)
                foreach ($images as $image)
                    FileUploader::uploadImage($image, 'blog/');

            foreach ($langs as $lang) {
                foreach ($post_data['NewsDescriptions' . $lang->id] as $key => $value) {
                    $descriptions[$lang->id]->{$key} = $value;
                }
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
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete()) {
            FileUploader::removeImage($model->images, 'blog/');
            NewsDescriptions::deleteAll(['parent_id' => $id]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
