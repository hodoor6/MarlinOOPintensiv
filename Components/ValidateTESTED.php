<?php
//require $_SERVER['DOCUMENT_ROOT'] . '/Components/DataBase.php';
//
//class Validate
//{
//
//    // $passed = false успешное прохождение проверки
//    //$erorrs = [] сбор ошибок в масив
//    private $passed = false, $erorrs = [], $db = null;
//
//    public function __construct()
//    {
//        //подключение к бд
//        $this->db = DataBase::getInstance();
//    }
//
//    public function check($source, $items = [])
//    {
//       //создание ключа если отправлен файл в массиве $_FILES
//        if (isset($_FILES)) {
//            foreach ($_FILES as $key => $name) {
//                $source[$key] = $name;
//
//            }
//        }
////разбиваем массив с правилами валидации на блоки $item  для проверки полей
//        foreach ($items as $item => $rules) {
//            foreach ($rules as $rule => $rule_value) {
//                $value = $source[$item];
//                if ($rule == 'required' and empty($value)) {
//
//                    $this->addErrors("{$item} должно быть заполнено обязательно (is required)");
//                } else if (!empty($value)) {
//                    switch ($rule) {
//                        case "min":
//                            if (mb_strlen($value) < $rule_value) {
//                                $this->addErrors("{$item} должно быть минимум $rule_value символа (characters.) ");
//                            }
//                            break;
//                        case "max":
//                            if (mb_strlen($value) > $rule_value) {
//                                $this->addErrors("{$item}  должно быть максимум (must be a maximum of)  $rule_value символов (characters.) ");
//                            }
//                            break;
//                        case "matches":
//                            if ($value != $source[$rule_value]) {
//                                $this->addErrors("$rule_value не совпадают (must match) {$item}");
//                            }
//                            break;
//                        case "uniqie":
//                            $check = $this->db->get($rule_value, [$item, '=', $value]);
//                            if ($check->count()) {
//                                $this->addErrors("{$item} существует (already exists .)");
//                            }
//                            break;
//                        case "type":
//                            $fileName = $_FILES[$item]['name'];
//                            $fileNameCmps = explode(".", $fileName);
//                            $fileExtension = strtolower(end($fileNameCmps));
//                                if (!empty($fileExtension) and !in_array($fileExtension,$rule_value)) {
//                                    $this->addErrors("{$item} разрешенный формат только " . implode(', ', $rule_value));
//                                }
//                            break;
//                        case "size":
//                            if ($value['size'] > $rule_value) {
//                                $size = substr($rule_value, 0, -6);
//                                $this->addErrors("{$item} максимальный размер загружаемого файла до {$size} мегабайт(а)");
//                            }
//                            break;
//                    }
//                }
//            }
//        }
//
//        //проверка на успешное прохождение без ошибок
//        if (!$this->erorrs) {
//            $this->passed = true;
//        }
//
//        return $this;
//    }
//
//
//    public function passed()
//    {
//        return $this->passed;
//    }
//
//    // сбор ошибок в середине метода
//    public function addErrors($error)
//    {
//        $this->erorrs[] = $error;
//    }
//
//    public function errors()
//    {
//        return $this->erorrs;
//    }
//
//
//
////    public function check($data, $params= [])
////   {
//////       var_dump($data, $params);
////       $result = [];
////
////        $this->erorrs = [];
////
////
//////           var_dump($field);die;
////        foreach ($data as $field)
////        {
////
////           foreach ($params as $key=>$value)
////               foreach ($params as $key=>$value)
////           {
////
////
//////               var_dump($key,$value);
////
//////           foreach ($value as $params)
//////           {
//////               var_dump($params);
////
////////       var_dump($params['name']['uniqie']);die;
//////
//////       $test = mb_strlen($data['name']);
//////               var_dump($params);die;
//////        $i=2;
////
//////
////////
//////        switch (mb_strlen($data['name'])){
//////            case "1":
//////            case "2":
//////                return 'имя должно быть минимум 3 символа';
//////                break;
//////            case 15:
//////                return 'максимальное допустимое имя в 15 символов';
//////                break;
//////            case 0:
//////                return 'это поле должно быть заполнено обязательно';
//////                break;
//////            default:
//////                return $test;
//////        }
////
////               if($params[$key]['min'] !=null) {
////
////
////                   if (mb_strlen($data[$field]) < $params[$key]['min']) {
//////    $minLength == 3
////                       $this->erorrs[] = "имя должно быть минимум ".$params[$key]['min'] ." символа";
////                   }
//////
////               }
////
////               if(mb_strlen($data['name']) > 15) {
//////    $minLength == 3
//////    $maxLength == 15;
////
////                   return 'максимальное допустимое имя в 15 символов';
////               }
////
////
////
//////               var_dump($params[$key]['required']);
////               if($params[$key]['required'] == true and mb_strlen($data[$key]) == 0) {
//////    $minLength == 3
//////    $maxLength == 15;
////
////                   $this->erorrs= 'это поле должно быть заполнено обязательно';
////               }
////
////               var_dump($params[$key]['matches']);
////               if($params[$key]['matches'] !=null){
////
////
////                   $data[$params[$key]['matches']] =
////                   var_dump($data[$params[$key]['matches']]);
////                   var_dump($data[$params[$key]]);
////
////                   if($data[$params[$key]['matches']] == $data[$params[$key]]){
////                       $this->erorrs ='пароли совпадают';
////                   } else{
////                       $this->erorrs = 'пароли не совпадают';
////                   }
////               }
////
////
//////
//////
//////
//////
//////
//////
//////
//////
//////$requereLength;
//////
//////return 'это поле должно быть заполнено обязательно';
//////var_dump($params[$key]['uniqie']);die;
////               if($params[$key]['uniqie'] !=null){
//////
//////        var_dump($uniqie->first()->name);die;
//////    var_dump($params[$key]['uniqie']);die;
////
////                   $uniqie = $this->db->get($params[$key]['uniqie'], ['name', '=', $data['name']])->first();
//////                   var_dump($uniqie);die;
////
////                   if($uniqie->name != null and $data['name']== $uniqie->name ){
////                       $this->erorrs =  'пользователь существует';
////                   } else
////                   {
////                       $this->erorrs=  'пользователь не существует';
////
////                   }
////
//////var_dump($uniqie);die;
//////       if(!$uniqie){
//////
//////
//////       }
////
////
////
////               }
////
////
//////       var_dump($test);die;
////
////
////
////           }
////
//////       }
////
////        }
////        var_dump($this);
////        return $this->errors;
////    }
//
//
//}
//
////testing
//
////if (Input::exists())
////{
////  echo  'форма отравлена';
////}else{
////    echo  ' форма не отравлена';
////}
////
////
////
////
////
////$test = 'ok';
////?>
<!---->
<!---->
<!--<!--<form action="" METHOD="get">-->-->
<!--<!--    <h1>Добавление пользователя</h1>-->-->
<!--<!--<p><label>Имя</label></p>-->-->
<!--<!--    <input name="name" type="text" value="-->--><? // // echo Input::get('name') ?><!--<!--">-->-->
<!--<!--    <p><label>Логин</label></p>-->-->
<!--<!--    <input name="login" type="text" value="-->--><?php ////echo $test ?><!--<!--" >-->-->
<!--<!--    <p><label>Почта </label></p>-->-->
<!--<!--    <input name="email"  type="text">-->-->
<!--<!--    <p><label>Пароль</label></p>-->-->
<!--<!--    <input name="password" type="text">-->-->
<!--<!--    <p></p>-->-->
<!--<!--    <input  type="submit" value="Добавить пользователя">-->-->
<!--<!--</form>-->-->
