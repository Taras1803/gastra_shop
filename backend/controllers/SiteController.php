<?php
namespace backend\controllers;

use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use backend\models\PasswordResetRequestForm;
use backend\models\ResetPasswordForm;
use backend\models\UpdateProfileForm;
use backend\models\Manager;
use backend\models\ManagerRoles;
use common\models\Options;
use common\models\Notifications;
use backend\models\UpdateManagerForm;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @Before Action
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if ($action->id == 'error' && Yii::$app->user->isGuest)
                $this->layout = 'main-login';
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'request-password-reset', 'reset-password'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'profile', 'options', 'file-manager', 'managers', 'db'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'main-login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        $this->layout = 'main-login';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        $this->layout = 'main-login';

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $pagination = new Pagination([
            'defaultPageSize' => 30,
            'totalCount' => Notifications::find()->count()
        ]);

        return $this->render('index', [
            'notifications' => Notifications::find()->orderBy(['id' => SORT_DESC])->offset($pagination->offset)->limit($pagination->limit)->all(),
            'pagination' => $pagination
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionProfile()
    {
        $model = new UpdateProfileForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->updateProfile();
        }

        return $this->render('profile', [
            'user' => Manager::findOne(Yii::$app->user->id),
            'model' => $model,
            'roles' => ManagerRoles::roles()
        ]);
    }

    /**
     * Displays options page.
     *
     * @return string
     */
    public function actionOptions()
    {
        ManagerRoles::userCan(1);
        return $this->render('options', [
            'options' => Options::find()->where(['show' => 1])->all()
        ]);
    }

    /**
     * Displays DB.
     *
     * @return string
     */
    public function actionDb()
    {
        require_once __DIR__ . '/../components/adminer.php';
        exit();
    }

    /**
     * Displays File Manager (yii2-elfinder).
     *
     * @return string
     */
    public function actionFileManager()
    {
        ManagerRoles::userCan(1);
        return $this->render('file-manager');
    }

    public function actionManagers()
    {
        ManagerRoles::userCan(1);
        $model = new UpdateManagerForm();
        $id = Yii::$app->request->get('id', 0);
        if ($id)
            if(!$model->loadData($id))
                return $this->redirect(['/managers']);
        if ($model->load(Yii::$app->request->post()) && $model->saveManager()) {
            $model = new UpdateManagerForm();
        }

        return $this->render('managers', [
            'model' => $model,
            'roles' => [
                '2' => 'Менеджер'
            ],
            'managers' => Manager::find()->where(['>', 'role', 1])->all()
        ]);
    }
}
