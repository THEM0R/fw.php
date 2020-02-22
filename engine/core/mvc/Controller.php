<?php

namespace mvc;

use module\Helper;


abstract class Controller
{

  public $meta = [];

  /*
   * @array $route
   * текущий маршрут
   */
  public $route = null;
  public $controller = null;

  /*
   * @var $view
   * текущий вид
   */
  public $view = null;

  /*
   * @var $templates
   * текущий шаблон
   */
  public $theme = null;

  /*
   * @array $templates
   */
  public $vars = null;

  public $method = null;

  public function get_content_curl($url)
  {

    $ch = curl_init($url);

    //curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
    //curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

    // timeout
    curl_setopt($ch, CURLOPT_TIMEOUT, 9);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 6);

    //curl_setopt( $ch, CURLOPT_POSTFIELDS, ['postdata' => 'test1'] );

    $res = curl_exec($ch);
    curl_close($ch);

    return $res;
  }


  public function __construct($model, $route)
  {


    //pr1( $this->get_content_curl('http://fw.php/ua/post/test12') );


    //pr($_SERVER['REQUEST_METHOD']);


    //pr1($route);

    // route
    $this->route = $route;

    $this->controller = Helper::lowerCamelCase($route['controller']);
    $this->view = $route['view'];
    // Language


    // theme
    if (!$this->theme) $this->theme = THEME;

    //pr1($this->configs);

    if( $this->controller === 'method' ){
      $this->method = $this->route['url'];
    }

  }


  public function getView()
  {
    $viewObject = new View($this->route, $this->theme, $this->view, $this->meta);

    if (is_dir(APP . '/views/' . $this->theme . '/')) {
      $theme = APP . '/views/' . $this->theme . '/';
    } else {
      $theme = null;
    }

    $configs = $this->configs;

    $meta = $this->meta;
    $route = $this->route;
    $controller = $this->controller;

    $all = compact('theme', 'route', 'meta', 'configs', 'controller');

    if ($this->vars) {
      $array = array_merge($all, $this->vars);
    } else {
      $array = $all;
    }


    // unset optimize
    unset($theme);
    unset($meta);
    unset($route);
    unset($all);

    $viewObject->rendering($array);

    // unset optimize
    unset($viewObject);
    unset($array);
  }

  public function render($vars = null)
  {
    $this->vars = $vars;

    // unset optimize
    unset($vars);
  }


}