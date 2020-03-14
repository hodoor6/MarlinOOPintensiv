<?php

class Config
{
    public static function get($path = null)
    {
        // проверяем существует ли путь
        if ($path) {
//принимает значение настроек из конфигурации
            $config = $GLOBALS['config'];
            // разбиваем путь на массив
            $newPath = explode('.', $path);
            // cоздаем доступ к массиву где лежит значение для вывода
            foreach ($newPath as $items) {
                if (isset($config[$items])) {
                    $config = $config[$items];
                } else {
                    return 'Такого значения нет в конфигурации';
                }
            }

            return $config;
        }
  return false;
    }


}








//    public static function get1($path = null)
//    {
//        if ($path){
//
//            $config = $GLOBALS['config'];
//            $newPath = explode('.', $path);
//
//
//            if(!empty(self::tree($config , $newPath)))
//            {
//                return self::tree($config , $newPath);
//            }
//        }
//
//        return 'Такого значения нет в конфигурации';
//    }
//
//    public static function tree($array, $data = [])
//    {
//             $result = '';
//        var_dump($lastKey = count($data)-1);
//
//        foreach ($array as $key => $value) {
//            if (is_array($value)) {
//                $result .= self::tree($value,$data);
//            } else {
//if($key == $data[$lastKey]){
//$result .= $value;
//}
//            }
//        }
//        return $result;
//    }
//
//}