<?php
require $_SERVER['DOCUMENT_ROOT'] . '/Components/DataBase.php';
?>
<h1>Редактирование пользователя</h1>
<form action="/Components/DataBase.php?id=<?=$user['id']?>" METHOD="post">
    <input name="name" type="text" value="<?= $user['name']?>">
    <input name="login" type="text" value="<?= $user['login']?>">
    <input name="email"  type="text" value="<?= $user['email']?>">
    <input name="password" type="text" value="<?= $user['password']?>">
    <input name="updateUser" type="submit" >
</form>