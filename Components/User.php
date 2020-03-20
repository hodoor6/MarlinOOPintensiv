<?php


class User
{
// $session_name - название сесии при авторизации
    private $db = null, $data = null, $session_name = null, $isLoggedIn;

//подключение к баз данных
    public function __construct($user = null)
    {
        $this->db = DataBase::getInstance();
        //получение имени сессии из $GLOBALS['config'] для дальнейшей использования
        $this->session_name = Config::get('session.user_session');
        if (!$user) {
            if (Session::exists($this->session_name)) {
                $id = Session::get($this->session_name); //id
                // проверка нашло ли значение  передано в сесcии в бд если нашло вернет true
                if ($this->find($id)) {
                    $this->isLoggedIn = true;
                } else {
                    //logaut
                }
            }
        } else {
            // вывод пользователя без авторизации по id
            $this->find($user);
        }
    }

// создание пользователя //добавление пользователя в базу
    public function create($fields = [])
    {
        $this->db->insert('users', $fields);
    }

// метод проверки пароля на совпадения и email для авторизации
    public function login($email = null, $password = null)
    {
        //поиск email по бд
        $user = $this->find($email);
        if ($user) {
            // проверка на совпадение по паролю
            if (password_verify($password, $this->data()->password)) {
                Session::put($this->session_name, $this->data()->id);
                return true;
            }
        }
        return false;
    }

// обертка над методом get для поиска по email или id в бд
    public function find($value = null)
    {
// проверка передаваемый тип
        if (is_numeric($value)) {
            $this->data = $this->db->get('users', ['id', '=', $value])->first();
        } else {
            $this->data = $this->db->get('users', ['email', '=', $value])->first();
        }
        //проверка на существование данных после выборки
        if ($this->data) {
            return true;
        }
        return false;
    }


//Getter для вывода данных на frandtend
    public function data()
    {
        return $this->data;
    }

//Getter для вывода cостояния при авторизации
    public function isLoggedIn()
    {
        return $this->isLoggedIn;
    }


}