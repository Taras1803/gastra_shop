<?php

/* @var $this yii\web\View */

$this->title = 'Опции';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div style="width: 99%; margin-left: 5px;">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 40%;">Значение</th>
                        <th style="width: 30%;">Описание</th>
                        <th style="width: 10%;">Инструменты</th>
                        <th style="width: 10%;">Уведомление</th>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>
                            <textarea cols="30" rows="1" class="item-data required" placeholder="slug"
                                      name="slug"></textarea>
                            <textarea cols="30" rows="1" class="item-data required" placeholder="value"
                                      name="value"></textarea>
                        </td>
                        <td>
                            <textarea cols="30" rows="1" class="item-data" placeholder="description"
                                      name="description"></textarea>
                        </td>
                        <td style="text-align: center;">
                            <a class="saveOptions" data-id="0" style="font-size: 20px;">
                                <i class="fa fa-save"></i>
                            </a>
                        </td>
                        <td style="text-align: center;
                        padding-top: 11px;">
                            <span class="badge bg-green" style="display: none;">Success</span>
                        </td>
                    </tr>
                    <?php if($options): ?>
                        <?php foreach($options as $option): ?>
                            <tr>
                                <td><?= $option->id ?></td>
                                <td>
                                    <input type="text" class="form-control item-data required" name="value" value="<?= $option->value ?>">
                                </td>
                                <td><?= $option->description ?></td>
                                <td style="text-align: center;">
                                    <a class="saveOptions" data-id="<?= $option->id ?>" style="font-size: 20px;">
                                        <i class="fa fa-save"></i>
                                    </a>
                                </td>
                                <td style="text-align: center;
    padding-top: 11px;">
                                    <span class="badge bg-green" style="display: none;">Success</span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



