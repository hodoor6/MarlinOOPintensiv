<?php
require $_SERVER['DOCUMENT_ROOT'] . '/Components/DataBase.php';


?>
<h1>Страница пользователя</h1>

<table width="800" border="1" cellspacing="0" cellpadding="4" align="center">

    <tr>
        <th>№</th>
        <th>Имя</th>
        <th>Логин</th>
        <th>Email</th>
        <th>Пароль</th>
    </tr>
    <tr>
              <td>
            <?= $user['id'] ?>

        </td>
        <td>
            <?= $user['name'] ?>
        </td>

        <td>
            <?= $user['login'] ?>
        </td>
        <td>
            <?= $user['email'] ?>
        </td>
        <td>
            <?= $user['password'] ?>
        </td>

    </tr>

    </table>
