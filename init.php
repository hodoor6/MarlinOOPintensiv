<?php
session_start();
require_once 'Components/lib/dbconfig.php';
require_once 'Components/DataBase.php';
require_once 'Components/Config.php';
require_once 'Components/Validate.php';
require_once 'Components/Input.php';
require_once 'Components/Token.php';
require_once 'Components/Session.php';
require_once 'Components/User.php';
require_once 'Components/Redirect.php';
require_once 'Components/Cookie.php';



//echo  $checkCookie =Cookie::get(Config::get('cookie.cookie_name'));

if(Cookie::exists(Config::get('cookie.cookie_name')) && !Session::exists(Config::get('session.user_session'))){
    $hash =Cookie::get(Config::get('cookie.cookie_name'));
$hashCheck = DataBase::getInstance()->get('user_sessions',['hash','=',$hash]);

if($hashCheck->count())
{
    $user = new User($hashCheck->first()->user_id);
    $user->login();

}


}
