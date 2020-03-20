<?php
require_once'init.php';
echo  Session::flash('login');
require_once 'Components/inludes/header.php';

$user = new User;
$anotherUser = new User(127);

//проверка на авторизацию пользователя
if($user->isLoggedIn()){
    echo  "Hi, <a href='#'>{$user->data()->name}</a>";
   echo  "<p><a href='logout.php'>Logout</a><p/>";
}else{
 echo "<p><a href='login.php'>login</a> or <a href='register.php'>Register</a><p/>";
}
?>
<?php require_once 'Components/inludes/footer.php' ?>
