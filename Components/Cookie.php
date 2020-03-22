<?php


class Cookie
{
// проверяем на существования куки если существует возвращаем true
    public static function exists($name)  {
        return (isset($_COOKIE[$name])) ? true : false;
    }
// получаем сессию
    public static function get($name)
    {
        return $_COOKIE[$name];
    }
//записиваем данные в cессию
    public static function put($name, $value, $expiry)
    {
        if(setcookie($name, $value, time() + $expiry,'/')){
            return true;
        }
        return false;
    }
//удаляет ссесию
    public static function delete($name)
    {
        self::put($name,'',time()-1);

    }


}