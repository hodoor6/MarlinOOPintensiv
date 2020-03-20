<?php
require $_SERVER['DOCUMENT_ROOT'] . '/Components/Config.php';

$GLOBALS['config'] = [
    'mysql' => [
        'driver' => 'mysql', // тип базы данных, с которой мы будем работать
        'host' => 'localhost', // альтернатива '127.0.0.1' - адрес хоста, в нашем случае локального
        'username' => 'root',  // имя пользователя для базы данных
        'password' => '', // пароль пользователя
        'database' => 'MarlinOopComponetsDataBase', // имя базы данных
        'charset' => 'utf8', // кодировка по умолчанию

    ],
    'session' => [
        'token_name'=>'token', // временое имя токена при отправки данных
        'user_session'=>'user' //  временная сессия пользователя c запись id при авторизации до выхода из сайта

    ]
];


