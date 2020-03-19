<?php


class Redirect
{
    //метод перенаправляет на указаную странину или на код ошибки что указан на странице где выполнялся редирект
    public static function to($location = null)
    {
        //проверяет передана строка или число
        if (is_numeric($location)){
            //блок отработки ошибок
          switch ($location) {
              case'404':
                  header("HTTP/1.0 404 Not Found");
                  include('inludes/error/404.php');
                  exit;
                  break;

          case'500':
              header('HTTP/1.0 500 Internal Server Error', true, 500);
                  include('inludes/error/500.php');
                  exit;
                  break;
          }
        }
        header("Location:" . $location);

    }

}