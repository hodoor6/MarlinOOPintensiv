<?php
require $_SERVER['DOCUMENT_ROOT'] . '/Components/DataBase.php';
?>
<h1>Список всех пользователей</h1>

<table width="800" border="1" cellspacing="0" cellpadding="4" align="center">

    <tr>
        <th>№</th>
        <th>Имя</th>
        <th>Вывод одного пользователя по логину</th>
        <th>Email</th>
        <th>Password</th>
        <th>Добавить</th>
        <th>Редактирование</th>
        <th>Удаление</th>

    </tr>

    <?php
    foreach ($users as $user){
    ?>
    <tr>
        <td>
            <?=$user->id ?>
        </td>
        <td>
            <?=$user->name ?>
        </td>
        <td>
            <a href="views/user.php?idUser=<?=$user->id?>"><?=$user->login?></a>
        </td>
        <td>
            <?=$user->email?>
        </td>
        <td>
            <?=$user->password?>
        </td>
        <td>
            <a href="views/register.php">Добавить</a>
        </td>

        <td>
            <a href="views/profile.php?idUserUpdate=<?=$user->id?>">Редактирование</a>
        </td>
   <td>
            <a href="/Components/DataBase.php?idUserDelete=<?=$user->id?>">Удаление</a>
        </td>

    </tr>
    <?php
    }
    ?>
    <table>
