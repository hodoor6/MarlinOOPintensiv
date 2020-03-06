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


//созданние приватного свойства для того чтобы по умолчанию подключение к бд было null реализация патерна сингелтон
    private static $instance = null;

// cоздание приватного construct  для того чтобы никто не мог получить доступ к нему реализация патерна сингелтон
    private function __construct()
    {
        $this->driver = 'mysql'; // тип базы данных, с которой мы будем работать
        $this->host = 'localhost';// альтернатива '127.0.0.1' - адрес хоста, в нашем случае локального
        $this->dbname = 'MarlinOopComponetsDataBase'; // имя базы данных
        $this->user = 'root'; // имя пользователя для базы данных
        $this->password = ''; // пароль пользователя
        $this->charset = 'utf8'; // кодировка по умолчанию

        $dsn = "$this->driver:host=$this->host;dbname=$this->dbname;charset=$this->charset";
// Setting options
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
// Making the connection to the database
        try {
            $this->pdo = new PDO($dsn, $this->dbuser, $this->dbpassword, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }

    }

// реализация патерна сингелтон через подключение к базе данных
    public static function getInstance()

    {
        if (!isset(self::$instance)) {

            self::$instance = new Database();
        }

        return self::$instance;
    }

    //- получить все записи из таблицы

    public function getAll($table)
    {
        $sql = "SELECT * FROM $table";
        $stmt = $this->pdo->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

//- получить одну запись из таблицы по id

    public function getOne($table, $id)

    {
        $sql = "SELECT * FROM $table where id=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }

    public function insert($table, array $data)
    {
        //удаление елемента массива так как он являеться кнопкой
        array_pop($data);
        $keys = array_keys($data);
        //присваиваю плесхолдерам значение ключей
        $column = implode(', ', $keys);
        $values = implode(', :', $keys);
        $sql = "INSERT INTO $table ($column) VALUE (:$values)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        header("Location:  /Components/testing/index.php");
    }

    //   - обновить данные записи в таблице по id
    public function update($table, $id, $data)

    {
//удаляю последный елемент масива
        array_pop($data);

        $keys = '';
        foreach ($data as $column => $value) {

            if ($column != 'id') {
                $keys .= $column . '=:' . $column . ', ';

            }
        }

        $keys = rtrim($keys, ', ');

        $sql = "UPDATE $table SET $keys  WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);

        $data['id'] = $id;

        $stmt->execute($data);
        header("Location:  /Components/testing/index.php");

    }

    //- удалить запись из таблицы по id
    public function delete($table, $id)

    {
        $id = implode('', $id);
        $sql = "DELETE FROM $table WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        header("Location:  /Components/testing/index.php");
    }


}
//тестинг













// то что должно быть в конторелере

// вывод патерна сингелтон реализация патерна сингелтон
$user = DataBase::getInstance();
//вывод всех пользователей
$table = 'users';
$users = $user->getAll($table );

if(!empty($_REQUEST['idUser']))
{
    $user = $user->getOne($table ,$_REQUEST['idUser']);

}

//вывод данныз на редактирование одного пользователя
if(!empty($_REQUEST['idUserUpdate']))
{
    $user =   $user->getOne($table ,$_REQUEST['idUserUpdate']);

}

//Добавления пользователя

if(!empty($_REQUEST['addUser']))
{

    $user->insert($table , $_REQUEST);
}

//Обновление  данных пользователя
if(!empty($_REQUEST['updateUser']) and isset($_REQUEST['updateUser'] )) {
//var_dump($_REQUEST);

    $user->update($table , $_GET['id'], $_POST);

}
//удаление пользователя

if(!empty($_REQUEST['idUserDelete']))
{

    $user->delete($table , $_REQUEST);
}
