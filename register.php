<?php
require_once 'init.php';

if (Input::exists('post')) {
    if (Token::check(Input::get('token'))) {
        $validator = new Validate();
        $validation = $validator->check($_POST, [
            'name' => [
                'required' => true,
                'min' => '3',
                'max' => '15',
                'uniqie' => 'users'
            ],
            'email' => [
                'required' => true,
                'email' => true,
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

        ]);

        if ($validation->passed()) {
            Session::flash('success', 'register success');
            // создание пользователя  и хеширование пароля
            $user = new User;
            $user->create([
                'name' => Input::get('name'),
                'password' => password_hash(Input::get('name'), PASSWORD_DEFAULT),
                'email' => Input::get('email')
            ]);
           echo Session::flash('success');
            //перенаправляет страницу
//            Redirect::to('/Components/testing/index.php');
        } else {
            foreach ($validation->errors() as $error) {
                echo $error . '</br>';
            }
        }
    }
}


?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- Кодировка веб-страницы -->
    <meta charset="utf-8">
    <!-- Настройка viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Подключаем Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>
<body>




<div class="container">
    <h2>Добавление пользователя</h2>
    <div class="row">
        <form action="" enctype="multipart/form-data" METHOD="post">
            <div class="form-group">
                <label for="name">Username</label>
                <input type="text" class="form-control" name="name" placeholder="Enter username"
                "<? echo Input::get('name') ?>">
            </div>
            <div class="form-group">
                <label for="name">Email address</label>
                <input type="text" class="form-control" name="email" placeholder="Enter email"
                "<? echo Input::get('email') ?>">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                    else.</small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="text" class="form-control" name="password" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password again</label>
                <input type="text" class="form-control" name="password_again" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="hidden" class="form-control" name="token" value="<? echo Token::generate() ?>">
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>
</div>

<!-- Подключаем jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Подключаем плагин Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>

<!-- Подключаем Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>

</body>
</html>