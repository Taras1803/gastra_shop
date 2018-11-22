<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
$text_role = [
    1 => 'Administrator',
    2 => 'Manager',
]
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg"><b>Admin</b> ' . Yii::$app->params['site_name'] . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <li>
                    <a href="/" target="_blank" style="font-size: 18px;"><i class="fa fa-fw fa-home"></i></a>
                </li>
                <li class="dropdown notifications-menu">
                    <a href="<?= \yii\helpers\Url::home() ?>" class="dropdown-toggle">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning"><?= \common\models\Notifications::getCount() ?></span>
                    </a>
                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/manager/uploads/avatar/<?= Yii::$app->user->identity->avatar ?>" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?= Yii::$app->user->identity->username ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="/manager/uploads/avatar/<?= Yii::$app->user->identity->avatar ?>" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                <?= Yii::$app->user->identity->username ?>
                                (<?= \backend\models\ManagerRoles::getRoleName(Yii::$app->user->identity->role) ?>)
                                <small>Member since <?= date("d.m.Y", Yii::$app->user->identity->created_at ) ?></small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?= Html::a(
                                    'Профиль',
                                    ['/site/profile'],
                                    ['class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Выход',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
