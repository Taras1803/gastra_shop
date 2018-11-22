<?php
/* @var $this yii\web\View */

use yii\widgets\LinkPager;

$this->title = 'Главная';
$userTime = \common\models\CurrentTime::getUserOffsetTime();
?>

<div class="col-md-10 col-lg-offset-1 col-md-offset-1">
    <!-- Form Element sizes -->
    <div class="box box-success" style="padding: 10px;">
        <div class="box-body">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Уведомление</th>
                    <th>Дата</th>
                </tr>
                </thead>
                <tbody>
                <?php if($notifications): ?>
                    <?php foreach($notifications as $item): ?>
                        <tr>
                            <td><?= $item->value ?></td>
                            <td><?= date("H:i d.m.Y", $item->created_at + $userTime) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>
    <div class="pull-right">
        <?= LinkPager::widget([
            'pagination' => $pagination,
            'options' => [
                'class' => 'pagination'
            ]
        ]); ?>
    </div>
    <!-- /.box -->
</div>
<div class="clearfix"></div>