<?php
require $_SERVER['DOCUMENT_ROOT'] . '/Components/DataBase.php';

class Validate
{

    // $passed = false успешное прохождение проверки
    //$erorrs = [] сбор ошибок в масив
    private $passed = false, $erorrs = [], $db = null;

    public function __construct()
    {
        //подключение к бд
        $this->db = DataBase::getInstance();
    }

    public function check($source, $items = [])
    {
        //создание ключа если отправлен файл в массиве $_FILES
        if (isset($_FILES)) {
            foreach ($_FILES as $key => $name) {
                $source[$key] = $name;

            }
        }
//разбиваем массив с правилами валидации на блоки $item  для проверки полей
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {
                $value = $source[$item];
                if ($rule == 'required' and empty($value)) {

                    $this->addErrors("{$item} должно быть заполнено обязательно (is required)");
                } else if (!empty($value)) {
                    switch ($rule) {
                        case "min":
                            if (mb_strlen($value) < $rule_value) {
                                $this->addErrors("{$item} должно быть минимум $rule_value символа (characters.) ");
                            }
                            break;
                        case "max":
                            if (mb_strlen($value) > $rule_value) {
                                $this->addErrors("{$item}  должно быть максимум (must be a maximum of)  $rule_value символов (characters.) ");
                            }
                            break;
                        case "matches":
                            if ($value != $source[$rule_value]) {
                                $this->addErrors("$rule_value не совпадают (must match) {$item}");
                            }
                            break;
                        case "uniqie":
                            $check = $this->db->get($rule_value, [$item, '=', $value]);
                            if ($check->count()) {
                                $this->addErrors("{$item} существует (already exists .)");
                            }
                            break;
                        case "type":
                            $fileName = $_FILES[$item]['name'];
                            $fileNameCmps = explode(".", $fileName);
                            $fileExtension = strtolower(end($fileNameCmps));
                            if (!empty($fileExtension) and !in_array($fileExtension, $rule_value)) {
                                $this->addErrors("{$item} разрешенный формат только " . implode(', ', $rule_value));
                            }
                            break;
                        case "size":
                            if ($value['size'] > $rule_value) {
                                $size = substr($rule_value, 0, -6);
                                $this->addErrors("{$item} максимальный размер загружаемого файла до {$size} мегабайт(а)");
                            }
                            break;
                    }
                }
            }
        }

        //проверка на успешное прохождение без ошибок
        if (!$this->erorrs) {
            $this->passed = true;
        }

        return $this;
    }


    public function passed()
    {
        return $this->passed;
    }

    // сбор ошибок в середине метода
    public function addErrors($error)
    {
        $this->erorrs[] = $error;
    }

    public function errors()
    {
        return $this->erorrs;
    }


}


