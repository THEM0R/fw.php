<?php


namespace engine;

require_once __DIR__ . '/config/define.php';


class Router
{
  /**
   * @var $routes
   * масив роутов
   */
  protected static $routes = [];

  /**
   * @var $route
   * масив текущего роута роута
   */
  protected static $route = [];

  protected static $Patterns = [
      'int' => '[0-9]+',
      'str' => '[a-zA-Z\.\-_%]+',
      'all' => '[a-zA-Z0-9\.\-_%]+',
      'get' => '[a-zA-Z0-9\.\-_%=&?]+'
  ];

  public static function get($pattern, $route, $view = false)
  {

    if (is_string($route)) {

      if (SL) {

        if ($pattern == '') {
          $pattern = '(language:str)' . $pattern;
        } else {
          $pattern = '(language:str)/' . $pattern;
        }

      }

//      $pattern = $pattern . '?(get:get)?';

      //pr1($pattern);


      if (strpos($route, ':') === false) {

        self::$routes[$pattern] = [
            'controller' => $route,
            'view' => $view,
            'method' => ['name' => 'GET']
        ];

      } else {

        $route = explode(':', $route);

        self::$routes[$pattern] = [
            'controller' => $route[0],
            'action' => $route[1],
            'view' => $view,
            'method' => ['name' => 'GET']
        ];

      }

    } // is_string
  }

  public static function post($pattern, $route, $view = false)
  {

    if (is_string($route)) {

      if (SL) {

        if ($pattern == '') {
          $pattern = '(language:str)' . $pattern;
        } else {
          $pattern = '(language:str)/' . $pattern;
        }

      }

//      $pattern = $pattern . '?(get:get)?';


      if (strpos($route, ':') === false) {

        self::$routes[$pattern] = [
            'controller' => $route,
            'view' => $view,
            'method' => ['name' => 'POST']
        ];

      } else {

        $route = explode(':', $route);

        self::$routes[$pattern] = [
            'controller' => $route[0],
            'action' => $route[1],
            'view' => $view,
            'method' => ['name' => 'POST']
        ];

      }

    } // is_string
  }

  /**
   * @param $url
   * @return bool
   */
  protected static function getRoute($url)
  {
    foreach (self::$routes as $pattern => $route) {

      //pr($pattern);

      $pattern = self::convertPattern('#^' . $pattern . '$#i');
//      $pattern = self::convertPattern('#^' . $pattern .'?(get:get)?'. '$#i');

      //pr($pattern);



      if (preg_match($pattern, $url, $matches)) {

        //pr1($pattern);

        pr($url);
        pr($matches);

        foreach ($matches as $k => $v) {
          if (is_string($k)) {
            $route[$k] = $v;
          }
        }

        if (!isset($route['action'])) {
          $route['action'] = 'index';
        }

        if (SL) {
          if (isset($route['language'])) {
            if (!in_array($route['language'], ['ua', 'ru'])) {
              Helper::notFound();
            } else {
              $_SESSION[LANGUAGE] = $route['language'];
            }
          } else {
            Helper::notFound();
          }
        }

        $route['controller'] = Helper::upperCamelCase($route['controller']);
        self::$route = $route;
        return true;
      }
    }
    return false;
  }

  public static function Run()
  {

    //pr1(self::$routes);


    $url = rtrim($_SERVER['QUERY_STRING'], '/');

    if (SL) {
      /** якшо в $url пусто */
      if ($url === '') {
        Helper::redirect(DOMEN . '/' . LANGUAGE);
      }

      if (!in_array($url, LANGUAGES)) {
        if (strpos($url, '/') !== false) {
          if (strpos($url, '/') !== strlen(LANGUAGE)) {
            Helper::redirect(DOMEN . '/' . LANGUAGE . '/' . $url);
          }
        } else {

          if (in_array(substr($url, 0, 2), LANGUAGES)) {
            $url = substr($url, 2);
          }

          if (strpos($url, '&') === 0) {
            $url = substr($url, 1);
          }

          Helper::redirect(DOMEN . '/' . LANGUAGE . '/' . $url);
        }
      }
    }else{

      if (in_array(substr($url, 0, 2), LANGUAGES)) {

        $url = substr($url, 2);

        if (strpos($url, '/') === 0) {
          $url = substr($url, 1);
        }

        Helper::redirect(DOMEN . '/' . $url);
      }
    }


//    if (strpos($url, '&') !== false | strpos($url, '=') !== false) {
//      if (strpos($url, 'request') === false) {
//        if (SL) {
//          if (!in_array(explode('/', $url)[1], LANGUAGES)) {
//            $url = explode('/', $url)[1];
//          }
//        }
//
//        if (strpos($url, '&') === 0) {
//          $url = substr($url, 1);
//        }
//
//        Helper::redirect(DOMEN . '/request/' . '&' . $url);
//      }
//    }

//    pr1($url);


    if (self::getRoute($url)) {

//      pr1($url);

      //pr($_SERVER);
      //pr(HTTP_REFERER);

      // https://artkiev.com/blog/php-proxy-detected.htm
      // Убрать пустые элементы из массива


      if (self::$route['method']['name'] == $_SERVER['REQUEST_METHOD']) {

        if (self::$route['method']['name'] == 'GET') {

          self::$route['method']['data'] = Helper::array_clear($_GET);
        } else if (self::$route['method']['name'] == 'POST') {
          self::$route['method']['data'] = Helper::array_clear($_POST);
        }

        $controller = 'app\\controllers\\' . self::$route['controller'] . 'Controller';
        if (class_exists($controller)) {


          // модель
          $model = 'app\\models\\' . self::$route['controller'] . 'Model';
          if (class_exists($model)) {
            $modelObject = new $model(self::$route);

            // unset optimize
            unset($model);

          } else {
            $modelObject = null;
          }

          $ControllerObject = new $controller($modelObject, self::$route);
          $action = Helper::lowerCamelCase(self::$route['action']) . 'Action';

          // unset optimize
          unset($controller);

          if (method_exists($ControllerObject, $action)) {

            $ControllerObject->$action($modelObject, self::$route);
            $ControllerObject->getView();

            // unset optimize
            unset($modelObject);
            unset($ControllerObject);
            unset($action);

          } else {
            Helper::notFound();
          }

        } else {
          Helper::notFound();
        }

      } else {
        Helper::notFound('REQUEST_METHOD не співпадає');
      }


    } else {
      Helper::notFound();
    }
  }


  protected static function convertPattern($pattern)
  {

    if (strpos($pattern, '(') === false) {
      return $pattern;
    }

    pr1($pattern);

    //pr1(preg_replace_callback('#\((\w+):(\w+)\)#', ['self', 'replacePattern'], $pattern));

    return preg_replace_callback('#\((\w+):(\w+)\)#', ['self', 'replacePattern'], $pattern);
  }

  protected static function replacePattern($matches)
  {

    //pr1('(?<' . $matches[1] . '>' . strtr($matches[2], self::$Patterns) . ')');

    return '(?<' . $matches[1] . '>' . strtr($matches[2], self::$Patterns) . ')';
  }

  /**
   * [en] get remote address
   * [uk] отримати віддалену адресу
   * @return array|false|mixed|string
   */
  protected static function getIp()
  {
    if ($_SERVER) {
      if ($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
      elseif ($_SERVER['HTTP_CLIENT_IP'])
        $ip = $_SERVER['HTTP_CLIENT_IP'];
      else
        $ip = $_SERVER['REMOTE_ADDR'];
    } else {
      if (getenv('HTTP_X_FORWARDED_FOR'))
        $ip = getenv('HTTP_X_FORWARDED_FOR');
      elseif (getenv('HTTP_CLIENT_IP'))
        $ip = getenv('HTTP_CLIENT_IP');
      else
        $ip = getenv('REMOTE_ADDR');
    }

    return $ip;
  }

}