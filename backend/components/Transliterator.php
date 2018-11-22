<?php

namespace backend\components;

use Yii;


class Transliterator
{
    public static function transliterate($input)
    {
        $gost = array(
            "Є" => "ye", "І" => "i", "Ѓ" => "g", "і" => "i", "№" => "_", "є" => "ye", "ѓ" => "g",
            "А" => "a", "Б" => "b", "В" => "v", "Г" => "g", "Д" => "d",
            "Е" => "e", "Ё" => "yo", "Ж" => "zh",
            "З" => "z", "И" => "i", "Й" => "j", "К" => "k", "Л" => "l",
            "М" => "m", "Н" => "n", "О" => "o", "П" => "p", "Р" => "r",
            "С" => "s", "Т" => "t", "У" => "u", "Ф" => "f", "Х" => "x",
            "Ц" => "c", "Ч" => "ch", "Ш" => "sh", "Щ" => "shh", "Ъ" => "",
            "Ы" => "y", "Ь" => "", "Э" => "e", "Ю" => "yu", "Я" => "ya",
            "а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d",
            "е" => "e", "ё" => "yo", "ж" => "zh",
            "з" => "z", "и" => "i", "й" => "j", "к" => "k", "л" => "l",
            "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
            "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "x",
            "ц" => "c", "ч" => "ch", "ш" => "sh", "щ" => "shh", "ъ" => "",
            "ы" => "y", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya",
            " " => "_", "-" => "", "–" => "", "—" => "", "," => "_", "!" => "_", "@" => "_",
            "#" => "_", "$" => "", "%" => "", "^" => "", "&" => "", "*" => "",
            "(" => "", ")" => "", "+" => "", "=" => "", ";" => "", ":" => "",
            "'" => "", "\"" => "", "~" => "", "`" => "", "?" => "", "/" => "",
            "\\" => "", "[" => "", "]" => "", "{" => "", "}" => "", "|" => "", "." => ""
        );

        return mb_strtolower(strtr($input, $gost));
    }
}