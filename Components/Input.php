<?php


class Input
{
    //проверка сушествует ли выбранный запрос и  при отправке если пустой возвращает false;
    public static function exists($type = 'post')
    {
//определяем тип запроса
//        $type =$_SERVER['REQUEST_METHOD'];

 switch (mb_strtolower($type)){
     case'post':
 return (!empty($_POST)) ? true : false;
     case'get':
 return (!empty($_GET))  ?true  :false;
     default:
         return false;
         break;
 }
         }

// метод сохранения значений в полях при валидации, если валидация не прошла
    public static function get($item)
    {

        if (isset($_POST[$item])) {
            return $_POST[$item];

        } elseif (isset($_GET[$item])) {
            return $_GET[$item];
        } else {
            // если нет данных возвращает пустое значение
            return '';
        }

    }

}