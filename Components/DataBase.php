<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


class DataBase
{
    private $driver;
    private $host;
    private $dbname;
    private $dbuser;
    private $dbpassword;
    private $charset;
    private $pdo;


    // свойства которые относяться только методу к query;
    private $query, $error = false, $results = null, $count= null;
    public $massage = '';


//созданние приватного свойства для того чтобы по умолчанию подключение к бд было null реализация патерна сингелтон
    private static $instance = null;

// cоздание приватного construct  для того чтобы никто не мог получить доступ к нему реализация патерна сингелтон
    private function __construct()
    {
        $this->driver = 'mysql'; // тип базы данных, с которой мы будем работать
        $this->host = 'localhost';// альтернатива '127.0.0.1' - адрес хоста, в нашем случае локального
        $this->dbname = 'MarlinOopComponetsDataBase'; // имя базы данных
        $this->dbuser = 'root'; // имя пользователя для базы данных
        $this->dbpassword = ''; // пароль пользователя
        $this->charset = 'utf8'; // кодировка по умолчанию

        $dsn = "$this->driver:host=$this->host;dbname=$this->dbname;charset=$this->charset";

// установка pdo подключения
        try {
            $this->pdo = new PDO($dsn, $this->dbuser, $this->dbpassword);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, TRUE);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        } catch (PDOException $e) {
            die ("Ошибка подключения к базе данных: ".$e->getMessage());
        }
        }

// реализация патерна сингелтона через подключение к базе данных
    public static function getInstance()

    {
        if (!isset(self::$instance)) {

            self::$instance = new Database();
        }

        return self::$instance;
    }

    //метод для выполнения запросов обертка
    //- получить все запись из таблицы универсальный метод
    public function query($sql, $params = [])
    {

        //ошибка по умолчанию false
        $this->error = false;
        $this->query = $this->pdo->prepare($sql);
//проверка на сушествование масива
        if (count($params)) {
            $i = 1;
            //передача множества аргументов в value;
            foreach ($params as $value) {
                $this->query->bindValue($i, $value);
                $i++;
            }
        }

        // проверка на уход данных в бд
        if (!$this->query->execute()) {
            $this->massage = $this->query->errorInfo();
            $this->error = true;
            return $this;
        } else {


try{
   // выборка данных из бд
    $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
                   //полученные количество колонок из бд
            $this->count = $this->query->rowCount();
}catch (PDOException $e){
    //проверка на операции обновления удаления и добавление так как выборки после них нет
                return  $this;
            }

        }
// передача только объекта создаваемого класса
        return $this;
    }

    //оберка над для SELECT метода и DELETE
    public function action($table, $where= [], $action)
    {
              $this->error = false;

        if (isset($where) and count($where) == 3) {
            //масив разрешеных операторов
            $operators = ['=', '>', '<', '>=', '<=', 'IS', 'IN', 'LIKE'];
            // разделения масива по переменим
            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];
// проверка если ли разрешеный оператор
            if (in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field}  {$operator} ?";

                if (!$this->query($sql, [$value])->error()) {
                    return $this;
                }
            } else{

                $this->massage = 'не верно веден оператор';
            }
        } else {

            $this->massage = 'ведите три значения';
        }

        $this->error = true;
       return $this;
    }

////- получить все записи из таблици из таблицы по id или все записи

  public function get($table, $where = [])
    {
     return   $this->action($table, $where, 'SELECT *');
    }

    //    //- удалить запись из таблицы по id

    public function delete($table, $where = [])
    {
        return   $this->action($table, $where, 'DELETE');

    }

//вставка данных веденых форму

    public function insert($table, $fields = []) {


        $values= '';
        foreach ($fields as $key=>$field)
        {
            $values .="?,";
        }
        $values =rtrim($values, ',');

        $sql = "INSERT INTO {$table} (`".implode('`, `', array_keys($fields))."`) VALUES ({$values})";
        $this->query = $this->pdo->prepare($sql);

        if(!$this->query($sql,$fields)->error())
        {
            return $this;
        }
        return $this;
    }
//метод обновление данных пользователя
//   - обновить данные записи в таблице по id
    public function update($table, $id,$fields = []) {
        //удаляю последный елемент масива
        array_pop($fields);
        $set= '';
        foreach ($fields as $key=>$field)
        {
            $set .=$key."=?,";
        }
        $set =rtrim($set, ',');

        try{
            $this->query = $this->pdo->prepare("SELECT id FROM users WHERE id ={$id} LIMIT 1 ");
            $this->query->execute();
        }catch (PDOException $e){
            if($this->query->rowCount() == 0 ){
                $this->massage = 'id в системе такого нет ' . $e->getMessage();
                $this->error = true;
                return $this;
            }
        }

        $sql = "UPDATE {$table} SET {$set} WHERE id= {$id}";

        if(!$this->query($sql,$fields)->error())
        {
            return $this;
        }

        $this->error = true;
        return $this;
    }



    //метод выборки одного пользователя

    public function first()
    {
        return  $this->results()[0];
    }
// getter получает приватное свойство error
    public function error()
    {
        return $this->error;
    }

// getter получает приватное свойство results
    public function results()
    {
        return $this->results;
    }

// getter получает приватное свойство count

    public function count()
    {
        return $this->count;
    }

}

// то что должно быть в конторелере

// вывод патерна сингелтон реализация патерна сингелтон
$connect = DataBase::getInstance();


//вывод всех пользователей
$connect->get('users',['id','>','0']);

if($connect->error()){
    echo 'есть ошибки'. "<br>";
    print_r($connect->massage);

}else {
    $users = $connect->get('users',['id','>','0'])->results();
}




//вывод одного пользователя

if (!empty($_REQUEST['idUser'])) {
    $connect->get('users', ['id', '=', $_REQUEST['idUser']])->first();
//вывод ошибок
    if($connect->error()){
        echo 'есть ошибки'. "<br>";
        print_r($connect->massage);
    }
    $user = $connect->get('users', ['id', '=', $_REQUEST['idUser']])->first();
}
//вывод данныз на редактирование одного пользователя
if (!empty($_REQUEST['idUserUpdate'])) {
    $connect->get('users', ['id' ,'=' ,$_GET['idUserUpdate']]);

    if($connect->error()){
        echo 'есть ошибки'. "<br>";
        print_r($connect->massage);


    }else{
        $userEdit = $connect->get('users', ['id' ,'=' ,$_REQUEST['idUserUpdate']]);

    }
}

//Добавления пользователя

if (!empty($_REQUEST['addUser'])) {

    $connect->insert('users', $_POST);

    if($connect->error()){
        echo 'есть ошибки'. "<br>";
        print_r($connect->massage);

    }else{
        header("Location:  /Components/testing/index.php");

    }
}

//Обновление  данных пользователя
if (!empty($_REQUEST['updateUser']) and isset($_REQUEST['updateUser'])) {
//var_dump($_REQUEST);

    $updateUser =  $connect->update('users', $_GET['id'], $_POST);

    if($connect->error()){
        echo 'есть ошибки'. "<br>";
        print_r($connect->massage);

    }else{

        header("Location:  /Components/testing/index.php");
    }

}
//удаление пользователя

if (!empty($_REQUEST['idUserDelete'])) {

    $connect->delete('users', ['id', '=' ,$_GET['idUserDelete']]);

    if($connect->error()){
        echo 'есть ошибки'. "<br>";
        print_r($connect->massage);


    }else{

        header("Location:  /Components/testing/index.php");
    }

}


//тестинг
//реализация метода insert
//$insertuser = DataBase::getInstance()->insert('users',['name'=>'name85','login'=>'login85','email'=>'email85','password'=>'password85']);
//// вывод ошибок  если при выполнении запроса есть ошибка
//    if ($insertuser->error()) {
//вывод сообщения об ошибке
//        print_r($insertuser->massage);
//        echo ' ошибки есть';
//    }


//реализация метода update
//$updatetest = DataBase::getInstance()->update('users','597',['name' => 'name',  'login' => 'login60','email' => 'email10','password' => '9']);
// //вывод ошибок  если при выполнении запроса есть ошибка
//    if ($updatetest->error()) {
//        print_r($updatetest->massage);
//        echo ' ошибки есть';
//
//    }
// реализация метода на вывод одного пользователя
//$getOneTest = DataBase::getInstance()->get('users',['login','=','login14']);
//проверка пользователя

//вывод ошибок
//if($getOneTest->error()){
//    print_r($getOneTest->massage);
//    echo 'есть ошибки';
//
//}else{
//
//проверка пользователя по свойству
//echo $getOneTest->first()->login;
//}




////реализация метода на удаление данных
//if(DataBase::getInstance()->get('users',['id','=','81'])->count() > 0) {
//
//    $deletetest = DataBase::getInstance()->delete('users', ['id', '=', '103']);
//
//     //вывод ошибок  если при выполнении запроса есть ошибка
//    if ($deletetest->error()) {
//        print_r($deletetest->massage);
//        echo ' ошибки есть';
//
//    }
//    }


////метод на выборку запрос на выполнеиие и выборку
//if (DataBase::getInstance()->get('users', ['login', '=', '2'])->count() > 1) {
//    $gettest = DataBase::getInstance()->get('users', ['login', '=', 'login27']);
//
//// вывод ошибок  если при выполнении запроса есть ошибка
//    if ($gettest->error()) {
//
//        print_r($gettest->massage);
//        echo ' ошибки есть';
//
//    } else {
//        //вывод данных если нет ошибок
//        var_dump($gettest->results());
//    }
//}


////тестирование метода query путем выборки всех пользователей
//$userstest = DataBase::getInstance()->query("SELECT * FROM users where email IN (?,?)", ['email5','email5']);
////
//// //вывод ошибок  если при выполнении запроса есть ошибка
//if($userstest->error()){
//    print_r($userstest->massage);
//    echo 'есть ошибки';
//
//}else{
//
////вывод результата массива что получился при выборке
//    $userstest->results();
////проверка вывода
//    var_dump($userstest->results());
////// подсчет количества выбранных строк
//    var_dump($userstest->count());
//}




