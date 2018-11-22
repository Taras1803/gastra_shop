<?php

namespace backend\controllers;

use common\models\ProductsAttributesValues;
use Yii;
use common\models\ProductsAttributes;
use backend\models\ProductsAttributesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductsAttributesController implements the CRUD actions for ProductsAttributes model.
 */
class ProductsAttributesController extends Controller
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
     * Lists all ProductsAttributes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsAttributesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductsAttributes model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'attribute_to_values' => ProductsAttributesValues::findAll(['product_attributes_id' => $id]),
        ]);
    }

    /**
     * Creates a new ProductsAttributes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductsAttributes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProductsAttributes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProductsAttributes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionSaveValueToAttribute()
    {
        $data = Yii::$app->request->post();
        if(!$data)
            return $this->redirect(['index']);

        if($data['id'] == 0)
            $value = new ProductsAttributesValues();
        else
            $value = ProductsAttributesValues::findOne($data['id']);

        $value->product_attributes_id = (int)$data['attributes_id'];
        $value->ru = $data['item']['ru'];
        $value->uk = $data['item']['uk'];
        $value->value = $data['item']['value'];
        $value->save();
    }

    public function actionRemoveValueToAttribute()
    {
        $data = Yii::$app->request->post();
        if(!$data)
            return $this->redirect(['index']);
        if(ProductsAttributesValues::findOne($data['id'])->delete())
            echo 'done';
    }

    /**
     * Finds the ProductsAttributes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductsAttributes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductsAttributes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
