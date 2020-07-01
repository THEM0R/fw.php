<?php

namespace router;

use module\Helper;
use module\Request;
use module\Language;

class Router
{

  public function __construct()
  {
    $this->url = Request::getUrl();
    require_once ENGINE_DIR . '/config.php';
  }

  private $url;

  /**
   * @var $routes
   * масив роутов
   */
  public $routes = [];
  public $routeName;

  /**
   * @var $route
   * масив текущего роута роута
   */
  protected $route = [];

  protected $Patterns = [
      'int' => '[0-9]+',
      'str' => '[a-zA-Z\.\-_%]+',
      'all' => '[a-zA-Z0-9\.\-_%]+',
      'get' => '[a-zA-Z0-9\.\-_%=&?]*'
  ];


  /**
   * @param $regex
   * @param $controller
   * @param bool $view
   * @return $this
   */
  public function get($regex, $controller, $view = false)
  {
    $this->addRoute($regex, $controller, $view, 'GET');
    return $this;
  }


  /**
   * @param $regex
   * @param $controller
   * @param bool $view
   * @return $this
   */
  public function post($regex, $controller, $view = false)
  {
    $this->addRoute($regex, $controller, $view, 'POST');
    return $this;
  }

  public function name($name = '')
  {
    $this->routes[$this->routeName]['name'] = $name;
    return $this;
  }


  /**
   * @param $pattern
   * @param $route
   * @param bool $view
   * @param string $method
   */
  public function addRoute($pattern, $route, $view = false, $method = 'GET')
  {
    if (is_string($route)) {

      $pattern = Language::LangToPattern($pattern);

      $this->routeName = $pattern;

      if (strpos($route, ':') === false) {

        $this->routes[$pattern] = [
            'controller' => $route
        ];

      } else {

        $route = explode(':', $route);

        $this->routes[$pattern] = [
            'controller' => $route[0],
            'action' => $route[1]
        ];
      }

      $this->routes[$pattern] += [
          'view' => $view,
          'method' => ['name' => $method]
      ];
    } // is_string
  }

  private function getMvc($route, $controller_link, $model_link, $directory){

    $controller = $controller_link . $route['controller'] . 'Controller';

    if (class_exists($controller)) {

      // модель
      $model = $model_link . $route['controller'] . 'Model';
      if (class_exists($model)) {
        $modelObject = new $model($route);

        // unset optimize
        unset($model);

      } else {
        $modelObject = null;
      }


      $ControllerObject = new $controller($modelObject, $route);
      $action = Helper::lowerCamelCase($route['action']) . 'Action';

      // unset optimize
      //unset($controller);

      if (method_exists($ControllerObject, $action)) {

        $ControllerObject->$action($modelObject, $route);
        $ControllerObject->getView($directory);

        // unset optimize-
        unset($modelObject);
        unset($ControllerObject);
        //unset($action);

      } else {
        Helper::notFound('no method in ' . $controller . ' ' . $action);
      }

    } else {
      Helper::notFound('no controller ' . $controller);
    }

  }


  /**
   * @START PROGRAM
   */
  public function Run()
  {

    Language::langRedirect($this->url);

    if ($this->getRoute($this->url)) {

      // *
      // route add method
      // *
      $this->route = Request::addMethod($this->route);

      if ($this->route['controller'] === 'Admin') {
        // *
        // if controller admin
        // *
        $this->route['controller'] = 'Main';
        $this->getMvc($this->route,ADMIN_CONTROLLER_LINK,ADMIN_MODEL_LINK,ADMIN_DIR);

      } else {
        // *
        // if controller no admin
        // *
        $this->getMvc($this->route,BASE_CONTROLLER_LINK,BASE_MODEL_LINK,BASE_DIR);
      }
    } else {
      Helper::notFound();
    }
  }


  /**
   * @param $url
   * @return bool
   */
  protected function getRoute($url)
  {

    foreach ($this->routes as $pattern => $route) {

      $pattern = $this->convertPattern("#^" . $pattern . "$#i");

      if (preg_match($pattern, $url, $matches)) {


        foreach ($matches as $k => $v) {
          if (is_string($k)) {
            $route[$k] = $v;
          }
        }

        if (!isset($route['action'])) {
          $route['action'] = 'index';
        }

        Language::searchLang($route);

        $route['controller'] = Helper::upperCamelCase($route['controller']);
        $this->route = $route;
        return true;
      }
    }
    return false;
  }

  /**
   * @return array $this->>routes
   */
  public function getRoutes()
  {
    return $this->routes;
  }


  /**
   * @param $pattern
   * @return string|string[]|null
   */
  protected function convertPattern($pattern)
  {

    if (strpos($pattern, '(') === false) {
      return $pattern;
    }

//        return preg_replace_callback("#\((\w+):(\w+)\)#", ['self', 'replacePattern'], $pattern);
    return preg_replace_callback("#\((\w+):(\w+)\)#", [$this, 'replacePattern'], $pattern);
  }

  /**
   * @param $matches
   * @return string
   */
  protected function replacePattern($matches)
  {
    return '(?<' . $matches[1] . '>' . strtr($matches[2], $this->Patterns) . ')';
    //return "(<" . $matches[1] . ">" . strtr($matches[2], $this->>Patterns) . ")";
  }

  /**
   * [en] get remote address
   * [uk] отримати віддалену адресу
   * @return array|false|mixed|string
   */
  protected function getIp()
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