<?php

namespace backend\controllers;

use Yii;
use common\models\PagesContent;
use backend\models\PagesContentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\ThemeVariables;
use common\models\Lang;
use common\models\PagesContentDescription;

/**
 * PagesContentController implements the CRUD actions for PagesContent model.
 */
class PagesContentController extends Controller
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
     * Lists all PagesContent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PagesContentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PagesContent model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'langs' => Lang::find()->orderBy(['default' => SORT_DESC])->all(),
            'descriptions' => PagesContentDescription::find()->where(['parent_id' => $id])->orderBy(['id' => SORT_ASC])->all()
        ]);
    }

    /**
     * Creates a new PagesContent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PagesContent();

        $langs = Lang::find()->orderBy(['default' => SORT_DESC])->all();
        $descriptions = [];
        foreach ($langs as $lang){
            $descriptions[$lang->id] = new PagesContentDescription();
            $descriptions[$lang->id]->parent_id = 0;
            $descriptions[$lang->id]->lang_id = $lang->id;
        }

        $post_data = Yii::$app->request->post();
        $model->created_at = time();
        $model->updated_at = time();
        if ($model->load($post_data) && $model->save()) {
            foreach ($langs as $lang){
                $descriptions[$lang->id]->parent_id = $model->id;
                foreach ($post_data['PagesContentDescription' . $lang->id] as $key => $value){
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
     * Updates an existing PagesContent model.
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
            $descriptions[$lang->id] = PagesContentDescription::findOne(['parent_id' => $id, 'lang_id' => $lang->id]);
        }

        $post_data = Yii::$app->request->post();
        $model->updated_at = time();
        if ($post_data && $model->save()) {
            foreach ($langs as $lang){
                foreach ($post_data['PagesContentDescription' . $lang->id] as $key => $value){
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
     * Deletes an existing PagesContent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        return $this->redirect(['index']);

        $this->findModel($id)->delete();
        PagesContentDescription::deleteAll(['parent_id' => $id]);

        return $this->redirect(['index']);
    }

    public function actionThemeVariables()
    {
        return $this->render('theme-variables', [
            'theme_variables' => ThemeVariables::find()->where(['type' => 0])->orderBy(['id' => SORT_DESC])->all(),
            'theme_images' => ThemeVariables::find()->where(['type' => 1])->orderBy(['id' => SORT_ASC])->all(),
        ]);
    }

    public function actionSaveThemeVariable()
    {
        header('Content-Type: text/html; charset=utf-8');
        ob_start();
        $data = Yii::$app->request->post();
        if (!ThemeVariables::saveVariable($data))
            echo 'fail';
        ob_end_flush();
        die;
    }

    /**
     * Finds the PagesContent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PagesContent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PagesContent::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
