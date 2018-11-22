<?php

namespace frontend\components;

use common\models\Currency;
use Yii;
use common\models\CurrentTime;
use common\models\Comment;
use common\models\Notifications;
use common\models\Options;

class ThemeHelper
{

    static function daysInMonth()
    {
        $time = time() + CurrentTime::getUserOffsetTime();
        $month = date("d", $time);
        $year = date("Y", $time);
        return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
    }

    static function sendWriteUsForm($post)
    {
        parse_str($post, $post);
        $file = (isset($_FILES['attach_file']))? $_FILES['attach_file'] : false;
        $json = [];
        $json['error'] = 0;
        $json['text'] = Yii::t('main', 'form_write_us_success');
        $json['action'] = 'clear_and_show_text';

        $mailer = Yii::$app
            ->mailer
            ->compose(
                ['html' => 'frontend/write_us-html'],
                ['data' => $post]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->params['site_name']])
            ->setTo(Options::getBySlug('admin_email'))
            ->setSubject('Напиши нам ' . Yii::$app->params['site_name']);

        $file_path = Yii::getAlias('@frontendweb/uploads/attach-files/');
        if($file && (int)$file['error'] == 0){
            if($file['size'] > 10000000){
                $json['error'] = 1;
                $json['text'] = Yii::t('main', 'error_form_send');
                return $json;
            }
            move_uploaded_file($file['tmp_name'], $file_path . $file['name']);
            $mailer->attach($file_path . $file['name']);
        }

        if ($mailer->send()) {
            unlink($file_path . $file['name']);
            Notifications::addMessage(0, 1, 'write_us', []);
        } else {
            $json['error'] = 1;
            $json['text'] = Yii::t('main', 'error_form_send');
        }

        return $json;

    }

    static function sendCommentForm($post)
    {
        $json = [];
        $json['error'] = 0;
        $json['text'] = Yii::t('main', 'form_comment_success');
        $json['action'] = 'clear_and_show_text';

        $coment = new Comment();
        $coment->lang_id = $post['lang_id'];
        $coment->item_type = $post['item_type'];
        $coment->item_id = $post['item_id'];
        $coment->comment = $post['comment'];
        $coment->created_at = time();
        $coment->status = 0;
        $coment->user_id = 0;
        $coment->user_name = $post['user_name'];
        if($coment->save()){
            Notifications::addMessage(0, 1, 'comment', [$coment->id, $post['user_name']]);
        } else {
            $json['error'] = 1;
            $json['text'] = Yii::t('main', 'error_form_send');
        }

        return $json;
    }

    static function getCurrency()
    {
        if($symbol = Yii::$app->session->get('shop_currency', false)){
            return $symbol;
        }
        else {
            $option = Options::getBySlug('currency_symbol');
            Yii::$app->session->set('shop_currency', $option);
            return $option;
        }

    }
    static function getDefaultWeight()
    {
        if($symbol = Yii::$app->session->get('shop_defaultWeight', false)){
            return $symbol;
        }
        else {
            $option = Options::getBySlug('defaultWeight');
            Yii::$app->session->set('shop_defaultWeight', $option);
            return $option;
        }

    }

    static function priceCalculation($price, $action)
    {
        if(!Yii::$app->user->isGuest)
            $action += Yii::$app->user->identity->discount;

        if($action){
            $price = $price - ($price / 100 * $action);
        }
        return Currency::priceCalculation(round($price), 2);
    }

}
