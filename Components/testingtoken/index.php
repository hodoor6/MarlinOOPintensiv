<?php
session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/Components/Validate.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Components/input.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Components/Token.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Components/Session.php';

if (Input::exists('post')) {
    if (Token::check(Input::get('token'))){
        $validator = new Validate();
    $validation = $validator->check($_POST, ['name' => [
        'required' => true,
        'min' => '3',
        'max' => '15',
        'uniqie' => 'users'
    ],
        'password' => [
            'required' => true,
            'min' => '5',
        ],
        'password_again' => [
            'required' => true,
            'matches' => 'password',
        ],
        'my_file' => [

            'type' => ['png', 'jpg'],
            'size' => 3145728,
        ]
    ]);

    if ($validation->passed()) {
        echo 'все заполнено верно';
    } else {
        foreach ($validation->errors() as $error) {
            echo $error . '</br>';
        }
    }
}
}


?>


<form action="" enctype="multipart/form-data" METHOD="post">
    <h1>Добавление пользователя</h1>
    <p><label>Имя</label></p>
    <input name="name" type="text" value="<? echo Input::get('name') ?>">

    <p><label>Пароль</label></p>

    <input name="password" type="text" value="">
    <p><label>Повторите Пароль</label></p>
    <input name="password_again" type="text" value="">
    <p><label>Аватар</label></p>
    <input name="my_file" type="file" ">
    <input name="token" type="text" value="<? echo Token::generate() ?>">
    <br>
    <br>
    <input type="submit" value="Добавить пользователя">
</form>
