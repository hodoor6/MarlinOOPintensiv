<?php


class Token
{
//создаем уникальный токен  md5(uniqid() и записиваем его в сессию //присваеваем ему имя и глобального массива Config
    public static function generate()
    {
        return Session::put(Config::get('session.token_name'), md5(uniqid()));
    }
// проверяем полученный токен при оотправке формы $token == Session::get($tokenName)
    public static function check($token)
    {
        $tokenName = Config::get('session.token_name');
        // проверяем на существование токена в сессии Session::exists($tokenName)
              if (Session::exists($tokenName) && $token == Session::get($tokenName)) {
                  //ели проходит проверку удаляем значение с сессии
            Session::delete($tokenName);
            return true;
        }
            return false;
    }
}
