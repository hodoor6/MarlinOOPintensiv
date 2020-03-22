<?php
require_once 'init.php';
if (input::exists('post')) {
    if (Token::check(Input::get('token'))) {
//проверка на существование чекбокса
       $remember = Input::get('remember') === 'on' ? true : false;
             //валидация
        $validate = new Validate();
        $validate->check($_POST, [
            'email' => ['required' => true, 'email' => 'email'],
            'password' => ['required' => true]
        ]);


        if ($validate->passed()) {
//авторизация пользователя
            $user = new User;
            $login = $user->login(Input::get('email'), Input::get('password') , $remember);

            if ($login) {
                Session::flash('login', 'logged in successfully');
                Redirect::to('/index.php');
            } else {
                echo 'error failed';
            }

        } else {

            foreach ($validate->errors() as $error) {
                echo $error . '<br>';
            }
        }
    }
}
?>
<?php   require_once 'Components/inludes/header.php'; ?>
    <div class="container">
        <h2>Авторизация пользователя</h2>
        <div class="row">
            <form action="" METHOD="post">
                <div class="form-group">
                    <label for="name">Email address</label>
                    <input type="text" class="form-control" name="email" placeholder="Enter email"
                           value="<?php echo Input::get('email') ?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="text" class="form-control" name="password" placeholder="Password">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" name="token" value="<?php echo Token::generate() ?>">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>
<?php require_once 'Components/inludes/footer.php' ?>