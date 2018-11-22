<?php

namespace backend\components;

use Yii;


class FileUploader
{
    static function uploadImage($file, $path)
    {
        $temp_file = Yii::getAlias('@backendweb/uploads/temp/' . $file);
        if(!file_exists($temp_file))
            return $file;
        $storage_path = Yii::getAlias('@storage/web/source/' . $path);
        if(!file_exists($storage_path))
            mkdir($storage_path, '0777');
        copy($temp_file, $storage_path . $file);
        unlink($temp_file);
        return $file;
    }

    static function removeImage($files, $path)
    {
        $files = explode("|", $files);
        $storage_path = Yii::getAlias('@storage/web/source/' . $path);
        foreach ($files as $file){
            if(file_exists($storage_path . $file))
                unlink($storage_path . $file);
        }

    }
}