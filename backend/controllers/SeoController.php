<?php

namespace backend\controllers;

use Yii;
use common\models\Seo;
use backend\models\SeoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Lang;
use common\models\SeoDescription;

/**
 * SeoController implements the CRUD actions for Seo model.
 */
class SeoController extends Controller
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
     * Lists all Seo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SeoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Seo model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'langs' => Lang::find()->orderBy(['default' => SORT_DESC])->all(),
            'descriptions' => SeoDescription::find()->where(['parent_id' => $id])->orderBy(['id' => SORT_ASC])->all()
        ]);
    }

    /**
     * Creates a new Seo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Seo();

        $langs = Lang::find()->orderBy(['default' => SORT_DESC])->all();
        $descriptions = [];
        foreach ($langs as $lang){
            $descriptions[$lang->id] = new SeoDescription();
            $descriptions[$lang->id]->parent_id = 0;
            $descriptions[$lang->id]->lang_id = $lang->id;
        }
        $post_data = Yii::$app->request->post();
        if ($model->load($post_data) && $model->save()) {
            foreach ($langs as $lang){
                $descriptions[$lang->id]->parent_id = $model->id;
                foreach ($post_data['SeoDescription' . $lang->id] as $key => $value){
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
     * Updates an existing Seo model.
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
            $descriptions[$lang->id] = SeoDescription::findOne(['parent_id' => $id, 'lang_id' => $lang->id]);
        }

        $post_data = Yii::$app->request->post();

        if ($post_data) {
            foreach ($langs as $lang){
                foreach ($post_data['SeoDescription' . $lang->id] as $key => $value){
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
        ]);
    }

    /**
     * Deletes an existing Seo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if($model->delete()){
            SeoDescription::deleteAll(['parent_id' => $id]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Seo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Seo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Seo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
