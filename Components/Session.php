<?php

class Session
{
      //создаем сессию при генерации токена
    public static function put($name, $value)
    {
        return $_SESSION[$name] = $value;
    }
// проверяем на существования токена если существует возращаем true
    public static function exists($name)
    {
        return (isset($_SESSION[$name])) ? true : false;
    }
// удаляем данные с сессии
    public static function delete($name)
    {
        //обращаемся к методу из этого класса
        if (self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }
// получаем данные с сессии
    public static function get($name)
    {
        return $_SESSION[$name];
    }

    //метод flash для вывода одноразовых сообщенный

    public static function flash($name,$message = '')

    {
        // проверяет существует ли сессия
        if (self::exists($name) && self::exists($name) !== '') {
            //получает flash сообщение
           $session = self::get($name);
          self::delete($name);
          // возвращаем полученное сообщение
          return  $session;
        }else{
            //записивает в сессию сообщение
            self::put($name,$message);
        }


    }

}