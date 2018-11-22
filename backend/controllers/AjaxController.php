<?php
namespace backend\controllers;

use yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\Options;
use backend\components\Transliterator;
use backend\models\Manager;
use backend\models\ManagerRoles;
use common\models\CurrentTime;

/**
 * Site controller
 */
class AjaxController extends Controller
{
    /**
     * @behaviors
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['save-option', 'upload-image', 'upload-theme-image', 'remove-manager', 'generate-slug', 'set-user-offset-time'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * Save option
     *
     * @echo string
     */
    public function actionSaveOption()
    {
        ManagerRoles::userCan(1);
        $data = Yii::$app->request->post();
        if (!Options::saveOption($data))
            echo 'fail';
    }

    /**
     * Загрузка изображений в папку backend uploads
     */
    public function actionUploadImage()
    {
        $action_path = Yii::$app->request->post('path', '');
        if ($action_path != '') {
            $path = Yii::getAlias('@backendweb/uploads/' . $action_path);
        } else {
            $path = Yii::getAlias('@backendweb/uploads/');
        }
        $file = $_FILES['file'];
        $temp_name = explode(".", $file['name']);
        header('Content-Type: text/html; charset=utf-8');
        ob_start();
        $name = 'SM-' . time() . '.' . $temp_name[count($temp_name) - 1];
        if (move_uploaded_file($file['tmp_name'], $path . $name)) {
            echo $name;
        } else
            echo "fail";
        ob_end_flush();
        die;
    }


    /**
     * Загрузка изображений в storage
     */
    public function actionUploadThemeImage()
    {
        $action_path = Yii::$app->request->post('path', '');
        if ($action_path != '') {
            $path = Yii::getAlias('@frontendweb/uploads/' . $action_path);
        } else {
            $path = Yii::getAlias('@frontendweb/uploads/');
        }
        $file = $_FILES['file'];
        $temp_name = explode(".", $file['name']);
        header('Content-Type: text/html; charset=utf-8');
        ob_start();
        $name = 'SM-' . time() . '.' . $temp_name[count($temp_name) - 1];
        if (move_uploaded_file($file['tmp_name'], $path . $name)) {
            echo $name;
        } else
            echo "fail";
        ob_end_flush();
        die;
    }

    public function actionRemoveManager()
    {
        $data = Yii::$app->request->post();
        if($data['id'] && $data['id'] > 1){
            Manager::findOne($data['id'])->delete();
        }
    }

    public function actionGenerateSlug()
    {
        $name = Yii::$app->request->post('name', false);
        header('Content-Type: text/html; charset=utf-8');
        ob_start();
        if($name){
            echo Transliterator::transliterate($name);
        }
        ob_end_flush();
        die;
    }

    public function actionSetUserOffsetTime()
    {
        $data = Yii::$app->request->post();
        if($data['dtz']){
            CurrentTime::setUserOffsetTime($data);
        }
    }
}
