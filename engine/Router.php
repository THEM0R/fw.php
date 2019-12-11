<?php


namespace engine;


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
      'get' => '[a-zA-Z0-9\.\-_%=&]+'
  ];

  public static function get($pattern, $route, $view = false)
  {

    if (is_string($route)) {

      if ($pattern == '') {
        $pattern = '(language:str)' . $pattern;
      } else {
        $pattern = '(language:str)/' . $pattern;
      }


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

      if ($pattern == '') {
        $pattern = '(language:str)' . $pattern;
      } else {
        $pattern = '(language:str)/' . $pattern;
      }


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


      $pattern = self::convertPattern('#^' . $pattern . '$#i');

      if (preg_match($pattern, $url, $matches)) {

        foreach ($matches as $k => $v) {
          if (is_string($k)) {
            $route[$k] = $v;
          }
        }

        if (!isset($route['action'])) {
          $route['action'] = 'index';
        }

        if (isset($route['language'])) {

          if (!in_array($route['language'], ['ua', 'ru'])) {
            Helper::notFound();
          } else {
            $_SESSION[LANGUAGE] = $route['language'];
          }

        } else {
          Helper::notFound();
        }


        $route['controller'] = Helper::upperCamelCase($route['controller']);
        self::$route = $route;
        return true;
      }
    }
    return false;
  }

  public static function Run($url)
  {


    /** якшо в $url пусто */
    if ($url === '') {
      Helper::redirect(DOMEN . '/' . LANGUAGE);
    }


    //pr(LANGUAGES[1]);
    //pr($url);
    //strlen(LANGUAGE);

    if( !in_array($url,LANGUAGES)){

      if (strpos($url, '/') !== false) {

        if (strpos($url, '/') !== strlen(LANGUAGE)) {
          Helper::redirect(DOMEN . '/' . LANGUAGE . '/' . $url );
        }
      } else {
        Helper::redirect(DOMEN . '/' . LANGUAGE . '/' . $url );
      }

    }




    // if GET
//        if (Helper::is_Get($url)) {
//            if (strpos($url, '&')) {
//                $url = explode('&', $url)[0];
//            }
//        }

    //pr1($url);

    //pr3( self::getRoute($url) );

    if (self::getRoute($url)) {

      pr1(self::$route);

      if (self::$route['method']['name'] == $_SERVER['REQUEST_METHOD']) {

        if (self::$route['method']['name'] == 'GET') {
          self::$route['method']['data'] = array_slice($_GET, 1);
        } else if (self::$route['method']['name'] == 'POST') {
          self::$route['method']['data'] = $_POST;
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

    return preg_replace_callback('#\((\w+):(\w+)\)#', ['self', 'replacePattern'], $pattern);
  }

  protected static function replacePattern($matches)
  {
    return '(?<' . $matches[1] . '>' . strtr($matches[2], self::$Patterns) . ')';
  }

}