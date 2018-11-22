<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/manager/uploads/avatar/<?= Yii::$app->user->identity->avatar ?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username ?></p>

                <a href="javascript:void(0);"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
<!--        <form action="/manager/products/?ProductsSearch%5B" method="get" class="sidebar-form">-->
<!--            <div class="input-group">-->
<!--                <input type="text" name="products_id" class="form-control" placeholder="Search..."/>-->
<!--              <span class="input-group-btn">-->
<!--                <button type="submit" class="btn btn-flat"><i class="fa fa-search"></i>-->
<!--                </button>-->
<!--              </span>-->
<!--            </div>-->
<!--        </form>-->
        <!-- /.search form -->

        <?= \backend\components\SideBarMenu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => \backend\models\ManagerRoles::menu(Yii::$app->user->identity->role),
            ]
        ) ?>

    </section>

</aside>
