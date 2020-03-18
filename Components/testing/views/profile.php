<?php
require $_SERVER['DOCUMENT_ROOT'] . '/Components/DataBase.php';

?>

<h1>Редактирование пользователя</h1>
<form action="/Components/DataBase.php?id=<?= $userEdit->first()->id ?>" METHOD="post">
    <input name="name" type="text" value="<?= $userEdit->first()->name ?>">
    <input name="login" type="text" value="<?= $userEdit->first()->login ?>">
    <input name="email" type="text" value="<?= $userEdit->first()->email ?>">
    <input name="password" type="text" value="<?= $userEdit->first()->password ?>">
    <input name="updateUser" type="submit">
</form>