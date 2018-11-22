<?php

/* @var $this yii\web\View */

$this->title = 'Опции темы';
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
                        <th style="width: 10%;">Сохранить</th>
                        <th style="width: 10%;">Сообщение</th>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>
                            <textarea cols="30" rows="1" class="item-data required" placeholder="slug"
                                      name="slug"></textarea>
                            <textarea cols="30" rows="1" class="item-data" placeholder="value"
                                      name="value"></textarea>
                        </td>
                        <td>
                            <select name="type" class="item-data required">
                                <option value="0">Текс</option>
                                <option value="1">Картинка</option>
                            </select>
                            <textarea cols="30" rows="1" class="item-data" placeholder="description"
                                      name="description"></textarea>
                        </td>
                        <td style="text-align: center;">
                            <a class="saveThemeVariables" data-id="0" style="font-size: 20px; cursor:pointer;">
                                <i class="fa fa-save"></i>
                            </a>
                        </td>
                        <td style="text-align: center;
                                            padding-top: 11px;">
                            <span class="badge bg-green" style="display: none;">Success</span>
                        </td>
                    </tr>
                    <?php if ($theme_variables): ?>
                        <?php foreach ($theme_variables as $key => $variable): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td>
                                    <input type="text" class="form-control item-data" name="value"
                                           value="<?= $variable->value ?>">
                                </td>
                                <td><?= $variable->description ?></td>
                                <td style="text-align: center;">
                                    <a class="saveThemeVariables" data-id="<?= $variable->id ?>"
                                       style="font-size: 20px;">
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
<div class="row">
    <div style="width: 99%; margin-left: 5px;">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 50%;">Изображения</th>
                        <th style="width: 20%;">Описание</th>
                        <th style="width: 10%;">Сохранить</th>
                        <th style="width: 10%;">Сообщение</th>
                    </tr>
                    <?php if ($theme_images): ?>
                        <?php foreach ($theme_images as $key => $item): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td>
                                    <?php if ($item->slug == 'main_slider'): ?>
                                        <a href="#" class="addDropZone">Добавить изображение</a>
                                        <br>
                                    <?php endif; ?>
                                    <?php $images = explode(",", $item->value) ?>
                                    <?php foreach ($images as $img): ?>
                                        <div style="float: left; display: inline-block;">
                                            <?php if ($item->slug == 'main_slider'): ?>
                                                <a href="#" class="delDropZone" title="Удалить">X</a>
                                            <?php endif; ?>
                                            <div class="dropZone">
                                                <div class="imageBlock">
                                                    <img class="newImage" src="<?= Yii::$app->glide->createSignedUrl([
                                                        'glide/index',
                                                        'path' => 'images/' . $img,
                                                        'w' => 135
                                                    ], true) ?>"
                                                         style="display: inline-block; max-width: 100%; vertical-align: middle; max-height: 140px;">
                                                </div>
                                                <input type="file" accept="image/png,image/jpeg,image/svg+xml"
                                                       data-path="temp/" data-target="" data-action="">
                                                <input type="hidden" class="data-control item-data required"
                                                       name="value"
                                                       value="<?= $img ?>">
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                                <td><?= $item->description ?></td>
                                <td style="text-align: center;">
                                    <a class="saveThemeImages" data-id="<?= $item->id ?>"
                                       style="font-size: 20px; cursor:pointer;">
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
