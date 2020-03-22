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
            // создание пользователя  и хеширование пароля
            $user = new User;
            $user->create([
                'name' => Input::get('name'),
                'password' => password_hash(Input::get('name'), PASSWORD_DEFAULT),
                'email' => Input::get('email')
            ]);
            Session::flash('success', 'register success');
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

<?php   require_once 'Components/inludes/header.php'; ?>
<div class="container">
    <h2>Регестрация пользователя</h2>
    <div class="row">
        <form action=""  METHOD="post">
            <div class="form-group">
                <label for="name">Username</label>
                <input type="text" class="form-control" name="name" placeholder="Enter username"
                value="<?php echo Input::get('name') ?>">
            </div>
            <div class="form-group">
                <label for="name">Email address</label>
                <input type="text" class="form-control" name="email" placeholder="Enter email"
                       value="<?php echo Input::get('email') ?>">
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
                <input type="hidden" class="form-control" name="token" value="<?php echo Token::generate() ?>">
            </div>
                     <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>
</div>
<?php require_once 'Components/inludes/footer.php'?>
