<?php
require_once 'init.php';
if(input::exists('post')){
    if(Token::check(Input::get('token'))){
        //валидация
        $validate = new Validate();
        $validate->check($_POST ,[
        'email'=>['required'=>true,'email'=>'email'],
        'password'=>['required'=>true]
        ]);

if($validate->passed()){

    $user = new User;
    $login = $user->login(Input::get('email'),Input::get('password'));

    if ($login){
//        echo  'login successful';
        Session::flash('login', 'logged in successfully');
    }else{
        echo  'error failed';
    }

}else{

    foreach ($validate->errors() as $error){
        echo $error.'<br>';
    }

}

}
}
echo  Session::flash('login');
?>

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
                  <div class="form-group">
                <input type="hidden" class="form-control" name="token" value="<?php echo Token::generate() ?>">
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>
</div>
<?php require_once 'Components/inludes/footer.php'?>