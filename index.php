<?php
require_once'init.php';
echo  Session::flash('login');
require_once 'Components/inludes/header.php';
$user = new User;
//проверка на авторизацию пользователя
if($user->isLoggedIn()){
    echo  "Hi, <a href='#'>{$user->data()->name}</a>";
   echo  "<p><a href='logout.php'>Logout</a><p/>";
   echo  "<p><a href='update.php'>Update</a><p/>";
}else{
 echo "<p><a href='login.php'>login</a> or <a href='register.php'>Register</a><p/>";
}
?>
<?php require_once 'Components/inludes/footer.php' ?>
