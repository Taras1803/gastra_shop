<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%categories}}".
 *
 * @property int $id
 * @property string $image
 * @property string $slug
 * @property int $parent
 * @property int $sort
 * @property int $status
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%categories}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'parent', 'status', 'sort','image'], 'required'],
            [['parent', 'sort', 'status'], 'integer'],
            [['slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Изображение',
            'slug' => 'Ссылка',
            'parent' => 'Родительская',
            'sort' => 'Порядок Сортировки',
            'status' => 'Статус',
        ];
    }

    public function getCategoriesDescriptions()
    {
        $lang = Lang::getCurrent();
        return $this->hasOne(CategoriesDescriptions::class, ['parent_id' => 'id'])
            ->where(['lang_id' => $lang->id]);
    }

    static function getStatus()
    {
        return [
            0 => 'Выкл',
            1 => 'Вкл',
        ];
    }

    public function getParent()
    {
        if($this->parent == 0)
            return 'Является родительской';
        else {
            $category = self::findOne(['parent' => $this->parent]);
            if($category){
                return ($category->getCategoriesDescriptions()->one())->name;
            } else
                return '';
        }
    }

    static function getCategoriesParents()
    {
        $data = [];
        $data[0] = 'Основная категория';
        $main_cats = self::findAll(['parent' => 0]);
        foreach ($main_cats as $main_cat){
            $description = $main_cat->getCategoriesDescriptions()->one();
            $data[$main_cat->id] = $description->name;
            $name = $description->name . ' -> ';
            self::getChildren($main_cat->id, $data, $name);
        }

        return $data;
    }

    private static function getChildren($parent_id, &$data, $name)
    {
        $cats = self::findAll(['parent' => $parent_id]);
        if($cats){
            foreach ($cats as $cat){
                $description = $cat->getCategoriesDescriptions()->one();
                $data[$cat->id] = $name . $description->name;
                $temp_name = $name . $description->name . ' -> ';
                self::getChildren($cat->id, $data, $temp_name);
            }
        } return true;
    }
}
