<?php


class User
{
// $session_name - название сесии при авторизации
    private $db = null, $data = null, $session_name;

//подключение к баз данных
    public function __construct()
    {
        $this->db = DataBase::getInstance();
        //получение имени сессии из $GLOBALS['config'] для дальнейшей использования
        $this->session_name = Config::get('session.user_session');

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

// обертка над методом get для поиска по email в бд
    public function find($email = null)
    {
        if ($email) {
            $this->data = $this->db->get('users', ['email', '=', $email])->first();
            //проверка на существование данных после выборки
            if ($this->data) {
                return true;
            }
            return false;
        }
    }

//гетер для вывода приватного свойства data
    public function data()
    {
        return $this->data;
    }


}