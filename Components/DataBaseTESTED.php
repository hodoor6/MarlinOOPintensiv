<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
//
//
//class DataBase
//{
//    private $driver;
//    private $host;
//    private $dbname;
//    private $dbuser;
//    private $dbpassword;
//    private $charset;
//    private $pdo;
//
//
//    // свойства которые относяться только методу к query;
//    private $query, $error = false, $results, $count;
//    public $massage = '';
//
//
////созданние приватного свойства для того чтобы по умолчанию подключение к бд было null реализация патерна сингелтон
//    private static $instance = null;
//
//// cоздание приватного construct  для того чтобы никто не мог получить доступ к нему реализация патерна сингелтон
//    private function __construct()
//    {
//        $this->driver = 'mysql'; // тип базы данных, с которой мы будем работать
//        $this->host = 'localhost';// альтернатива '127.0.0.1' - адрес хоста, в нашем случае локального
//        $this->dbname = 'MarlinOopComponetsDataBase'; // имя базы данных
//        $this->dbuser = 'root'; // имя пользователя для базы данных
//        $this->dbpassword = ''; // пароль пользователя
//        $this->charset = 'utf8'; // кодировка по умолчанию
//
//        $dsn = "$this->driver:host=$this->host;dbname=$this->dbname;charset=$this->charset";
//// Setting options
//        $options = [
//           PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
////            PDO::ATTR_EMULATE_PREPARES => TRUE,
//            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
//
//        ];
//// gjlt
//        try {
//            $this->pdo = new PDO($dsn, $this->dbuser, $this->dbpassword, $options);
//                } catch (PDOException $e) {
//            $this->error = $e->getMessage();
//            var_dump($this->error);
//        }
//
//    }
//
//// реализация патерна сингелтон через подключение к базе данных
//    public static function getInstance()
//
//    {
//        if (!isset(self::$instance)) {
//
//            self::$instance = new Database();
//        }
//
//        return self::$instance;
//    }
//
//    //- получить все записи из таблицы
//
//    public function getAll($table)
//    {
//        $sql = "SELECT * FROM $table";
//        $stmt = $this->pdo->query($sql);
//        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
//        return $result;
//    }
//
////- получить одну запись из таблицы по id
//
//    public function getOne($table, $id)
//
//    {
//        $sql = "SELECT * FROM $table where id=:id";
//        $stmt = $this->pdo->prepare($sql);
//        $stmt->bindParam(':id', $id);
//        $stmt->execute();
//        $result = $stmt->fetch();
//        return $result;
//    }
//
//    public function insert($table, array $data)
//    {
//        //удаление елемента массива так как он являеться кнопкой
//        array_pop($data);
//        $keys = array_keys($data);
//        //присваиваю плесхолдерам значение ключей
//        $column = implode(', ', $keys);
//        $values = implode(', :', $keys);
//        $sql = "INSERT INTO $table ($column) VALUE (:$values)";
//        $stmt = $this->pdo->prepare($sql);
//        $stmt->execute($data);
//        header("Location:  /Components/testing/index.php");
//    }
//
//    //   - обновить данные записи в таблице по id
//    public function update($table, $id, $data)
//
//    {
////удаляю последный елемент масива
//        array_pop($data);
//
//        $keys = '';
//        foreach ($data as $column => $value) {
//
//            if ($column != 'id') {
//                $keys .= $column . '=:' . $column . ', ';
//
//            }
//        }
//
//        $keys = rtrim($keys, ', ');
//
//        $sql = "UPDATE $table SET $keys  WHERE id=:id";
//        $stmt = $this->pdo->prepare($sql);
//
//        $data['id'] = $id;
//
//        $stmt->execute($data);
//        header("Location:  /Components/testing/index.php");
//
//    }
////cтарый код
//    //- удалить запись из таблицы по id
//    public function delete($table, $id)
//
//    {
//        $id = implode('', $id);
//        $sql = "DELETE FROM $table WHERE id = :id";
//        $stmt = $this->pdo->prepare($sql);
//        $stmt->bindValue(':id', $id);
//        $stmt->execute();
//        header("Location:  /Components/testing/index.php");
//    }
//
//
//    //- получить все запись из таблицы универсальный метод
//    public function delete1($table, $where = [])
//    {
//      return    $this->action($table, $where, 'DELETE',null);
//
////      //моя реализация
////        header("Location:  /Components/testing/index.php");
//
////        if (count($delete) == 3) {
////            $operators = ['=', '<', '>', '>=', '<='];
////            $field = $delete[0];
////            $operator = $delete[1];
////            $value = $delete[2];
////
////            if (in_array($operator, $operators)) {
////
////            }
////
////            $sql = "DELETE  FROM {$table} WHERE  {$field} {$operator} ?";
////
////
////            if (!$this->query($sql, [$value])->error()) {
////                $this->error = true;
////
////                $this->massage = 'неверно ведены данные в массиве';
////            }
////
////        }
////
////        header("Location:  /Components/testing/index.php");
//
//    }
//
//    //метод для выполнения запросов
//
//    public function query($sql, $params = [], $action)
//    {
////        var_dump($sql);
//        //ошибка по умолчанию false
//        $this->error = false;
//        $this->query = $this->pdo->prepare($sql);
////проверка на сушествование масива
//        if (count($params)) {
//            $i = 1;
//            //передача множества аргументов в value;
//            foreach ($params as $value) {
//                $this->query->bindValue($i, $value);
//                $i++;
//            }
//        }
//
//
//        try {
//            $this->query->execute();
//            if ($action == "select") {
//                $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
//            }
//            $this->count = $this->query->rowCount();
//                  if ($action == 'insert' or $action == 'delete' or $action == 'update' ) {
//               return $this;
//            }
//        } catch (PDOException $ex) {
//            $this->massage = $this->query->errorInfo();
//            $this->error = true;
//            return $this;
//        }
//
//
//
//
//
////        // проверка на уход данных в бд
////        if (!$this->query->execute()) {
////            $this->massage = $this->query->errorInfo();
////            $this->error = true;
////            return $this;
////        } else {
//////проверка на пустопу после обновления удаления и обновления
////
////
////
////
////               if ($action == 'insert' or $action == 'delete' or $action == 'update' )
////               {
////                  return $this;
////
////               }
////
////            //выборка данных из бд
////            $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
////            //полученные поличество колонок из бд
////            $this->count = $this->query->rowCount();
////
////
////        }
//
//// передача только создаваемого класа
//        return $this;
//    }
//
//// getter получает приватное свойство error
//    public function error()
//    {
//        return $this->error;
//    }
//
//// getter получает приватное свойство results
//    public function results()
//    {
//        return $this->results;
//    }
//
//// getter получает приватное свойство count
//
//    public function count()
//    {
//        return $this->count;
//    }
//
//    public function action($table, $where= [], $action, $data = [])
//    {
//
//        var_dump($action);
//        var_dump($where);
//
//        $action = mb_strtolower(trim($action));
//        $sql_params = [];
//        $query_body = "";
//        $query_data = "";
//        $query_where = "";
//        $query_offset = "";
//        switch ($action) {
//
//            case 'select':
//                $query_body  = "SELECT * FROM {$table}";
//                break;
//            case'delete':
//                $query_body  = "DELETE FROM {$table}";
//                break;
//            case'insert':
//                $keys = array_keys($data);
//                $fill = implode(' ,', $keys);
//
//              $elems = array_fill(0,count($data) , '?');
//                $elems=  implode(', ' ,$elems);
//
//                $query_body  = "INSERT INTO {$table} ({$fill}) VALUES ({$elems})";
//foreach ($data as $values)
//{
//    $value[] = $values;
//}
//
//
//                break;
//            case'update':
//                $keys = array_keys($data);
//                /////
//var_dump($keys);
//foreach ($keys as $key){
//
//    $fill[]=   $key.'=?';
//}
//
//var_dump($fill);
//
//                $fill=  implode(', ' ,$fill);
//
//                $query_body  = "UPDATE {$table} SET {$fill} ";
////var_dump($sql);die;
//                $value = [];
//                foreach ($data as $values)
//                {
//                    $value[] = $values;
//                }
//
////                $value;
//
//                break;
//            default:
//               echo 'Неверно веден запрос в базу данных';
//        }
//
//
//        $this->error = false;
//        var_dump($where);
//        if (isset($where) and count($where) == 3) {
//            //масив разрешеных операторов
//            $operators = ['=', '>', '<', '>=', '<=', 'IS', 'IN', 'LIKE'];
//            // разделения масива по переменим
//            $field = $where[0];
//            $operator = $where[1];
//            $valueid = $where[2];
//// проверка если ли разрешеный оператор
//            if (in_array($operator, $operators)) {
//                $query_where = " WHERE {$field}  {$operator} ?";
//            }
//
//        }
//
//        if(isset($valueid)){
//
//            $value [] =$valueid;
//        }
//        $sql  =   $query_body . $query_where;
//                if (!$this->query($sql, $value,$action)->error()) {
//                    return $this;
//                }
////                return $this;
//
////            } else {
////                $this->error = true;
////
////                $this->massage = 'неверно веден оператор в массиве';
////            }
////        } else {
////            $this->error = true;
////            $this->massage = 'передаваемых аргуметов должно быть 3';
////        }
//$this->error = true;
//       return $this;
//    }
//
//
//    public function get($table, $where = [])
//    {
//     return   $this->action($table, $where, 'SELECT',null);
//
//
//    }
//
//    public function pdoSet($allowed, &$values, $source = array())
//    {
//     $set= '';
//     $values =array();
//
//
//     if(!$source)  $source = &$_POST;
//        foreach ($allowed as $field) {
//            if (isset($source[$field])) {
//                $set.="`".str_replace("`","``",$field)."`". "=?, ";
//
//                $values[$field] = $source[$field];
//                if ($field =='password') {
//
//                    $field = trim($field);
//
//
//
//                    $values[$field] = MD5($source[$field]);
//                }
//            }
//
//        }
//
//        return substr($set, 0, -2);
//    }
//
//
//
//
//
//
//
//    public function update1($table,$params=[], $where=[])
//    {
//        return  $this->action($table,$where, 'UPDATE', $params);
//
//
//
//
////моя реализация
////        $paramsAllowed = array("name","login","email","password");
////
////
////        $fields = $where[0];
////        $operator =$where[1];
////        $value =$where[2];
////
////
////        $sql = "UPDATE {$table} SET
////        ".$this->pdoSet($paramsAllowed,$values,$params)."
////        WHERE {$fields}  {$operator} ?";
////        $values[] =$value;
////
////        if(!$this->query($sql,$values))
////        {
////            return $this;
////        }
////
////        $this->error = true;
////        return $this;
//   }
//
//
//
//
//    public function insert1($table,$params=[])
//    {
//
//
//       return $this->action($table,null, 'INSERT', $params);
//
//////моя реализация
////        $paramsAllowed = ['name','login','email','password'];
////
////       $test = $this->pdoSet($paramsAllowed,$values,$params);
//////        var_dump($test); die;
////
////        $sql = "INSERT INTO {$table} SET".$this->pdoSet($paramsAllowed,$values, $params)."";
//////        var_dump($sql); die;
////
////        if(!$this->query($sql,$values))
////        {
////            return $this;
////        }
////        return $this;
//    }
//
//
//    public function getOne1($table,$where=[])
//    {
//        return   $this->action($table, $where, 'SELECT',null);
//
//////моя раелизация
////        if (isset($where) and count($where) == 3) {
////            //масив разрешеных операторов
////            $operators = ['=', '>', '<', '>=', '<=', 'IS', 'IN', 'LIKE'];
////            // разделения масива по переменим
////            $field = $where[0];
////            $operator = $where[1];
////            $value = $where[2];
////// проверка если ли разрешеный оператор
////            if (in_array($operator, $operators)) {
////                $sql = "SELECT * FROM {$table} WHERE  {$field}  {$operator} ?";
////            }else{
////                $this->massage = 'неверно ведет оператор';
////                $this->error = true;
////                return $this; }
////        }
////
////        if(!$this->query($sql,[$value]))
////        {
////            return $this;
////
////        }
////        return $this;
//    }
//
//}
//
//
//
//
//
//
//
////// реализация на вывод одного пользователя
////$getOneTest = DataBase::getInstance()->getOne1('users',['id','=','2']);
////
////$getOneTest->massage;
////
////if($getOneTest->error()){
////    print_r($getOneTest->massage);
////    echo 'есть ошибки';
////
////}else{
////
////    var_dump($getOneTest->results());
////}
//
//
//////реализация метода insert
////$insertuser = DataBase::getInstance()->insert1('users',['name1'=>'name9','login'=>'login9']);
////// var_dump($insertuser);
////// вывод ошибок  если при выполнении запроса есть ошибка
////    if ($insertuser->error()) {
////
////        print_r($insertuser->massage);
////        echo ' ошибки есть';
////
////    } else {
////        //вывод данных если нет ошибок
//////        var_dump($insertuser);
////    }
//
////реализация метода update
//$updatetest = DataBase::getInstance()->update1('users',['name1' => 'name',  'login' => 'login60','email' => 'email10','password' => '9'], ['id', '=', '60']);
//
//
// //вывод ошибок  если при выполнении запроса есть ошибка
//    if ($updatetest->error()) {
//
//        print_r($updatetest->massage);
//        echo ' ошибки есть';
//
//    } else {
//        //вывод данных если нет ошибок
//        var_dump($updatetest);
//    }
//
//
//
////if(DataBase::getInstance()->get('users',['login','=','login57'])->count() > 0 ) {
////
////    $updatetest = DataBase::getInstance()->update1('users', ['name' => 'name', 'login' => 'login59', 'email' => 'email50', 'password' => '9'], ['id', '=', '59']);
////
////}
////тестинг
//
//////удаленние данных
////if(DataBase::getInstance()->get('users',['id','=','79'])->count() > 0) {
////
////DataBase::getInstance()->delete1('users',['id','=','79']);
//////
//////    var_dump(  $test );
////    $deletetest = DataBase::getInstance()->delete1('users', ['name', '=', '2033']);
////}
//// var_dump($deletetest);
//// вывод ошибок  если при выполнении запроса есть ошибка
////    if ($deletetest->error()) {
////
////        print_r($deletetest->massage);
////        echo ' ошибки есть';
////
////    } else {
////        //вывод данных если нет ошибок
////        var_dump($deletetest);
////    }
////}
//
//
//// запрос на выполнеиие и выборку
//
////if(DataBase::getInstance()->get('users',['login','=','2'])->count() > 2)
////
////{
////$gettest = DataBase::getInstance()->get('users', ['id', '=', '2']);
////
//////    //вывод данных если нет ошибок
//////    var_dump($gettest->results());
////// вывод ошибок  если при выполнении запроса есть ошибка
////if ($gettest->error()) {
////
////    print_r($gettest->massage);
////    echo ' ошибки есть';
////
////} else {
////    //вывод данных если нет ошибок
////    var_dump($gettest->results());
////}
//////}
//////тестирование метода query путем выборки всех пользователей
////$userstest = DataBase::getInstance()->query("SELECT * FROM users where name IN (?, ?)", ['1','112']);
//////
////// //вывод ошибок  если при выполнении запроса есть ошибка
////if($userstest->error()){
////    print_r($userstest->massage);
////    echo 'есть ошибки';
////
////}else{
////    echo 'нет ошибок';
////}
//////вывод результата массива что получился при выборке
////$userstest->results();
////проверка вывода
////var_dump($userstest->results());
//////// подсчет количества выбранных строк
////var_dump($userstest->count());
//////
////
////
////
////
////
////
//
//
//// то что должно быть в конторелере
//
//// вывод патерна сингелтон реализация патерна сингелтон
//$user = DataBase::getInstance();
//
//
////вывод всех пользователей
//$table = 'users';
//$users = $user->getAll($table);
//
//
//if (!empty($_REQUEST['idUser'])) {
//    $user = $user->getOne($table, $_REQUEST['idUser']);
//
//}
//
////вывод данныз на редактирование одного пользователя
//if (!empty($_REQUEST['idUserUpdate'])) {
//    $user = $user->getOne($table, $_REQUEST['idUserUpdate']);
//
//}
//
////Добавления пользователя
//
//if (!empty($_REQUEST['addUser'])) {
//
//    $user->insert($table, $_REQUEST);
//}
//
////Обновление  данных пользователя
//if (!empty($_REQUEST['updateUser']) and isset($_REQUEST['updateUser'])) {
////var_dump($_REQUEST);
//
//    $user->update($table, $_GET['id'], $_POST);
//
//}
////удаление пользователя
//
//if (!empty($_REQUEST['idUserDelete'])) {
//
//    $user->delete($table, $_REQUEST);
//}
//
//
