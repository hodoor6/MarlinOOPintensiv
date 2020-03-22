<?php
require_once 'init.php';
$user = new User;
if (input::exists('post')) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validate->check($_POST, [
            'name' => ['required' => true, 'min' => 3, 'max' => 15],
            'email' => ['email' => 'email'],
        ]);
        if ($validate->passed()) {
            //обновление пользователя
            $update = $user->update(['name' => Input::get('name')]);
            Redirect::to('update.php');
        } else {
            foreach ($validate->errors() as $error) {
                echo $error . '<br>';
            }
        }
    }
}
?>
<?php require_once 'Components/inludes/header.php'; ?>
    <div class="container">
        <h2>Профиль пользователя</h2>
        <div class="row">
            <form action="" METHOD="post">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter name"
                           value="<?php echo $user->data()->name ?>">
                </div>

                <div class="form-group">
                    <label for="name">Email address</label>
                    <input type="text" class="form-control" name="email" placeholder="Enter email"
                           value="<?php echo $user->data()->email ?>">
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" name="token" value="<?php echo Token::generate() ?>">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>
<?php require_once 'Components/inludes/footer.php' ?>