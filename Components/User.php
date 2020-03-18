<?php


class User
{
    private $db = null;

//подключение к баз данных
    public function __construct()
    {
        $this->db = DataBase::getInstance();

    }
// создание пользователя //добавление пользователя в базу
    public function create($fields = [])
    {
        $this->db->insert('users', $fields);
    }
}