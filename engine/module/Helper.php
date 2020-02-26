<?php


namespace module;


class Helper
{

  public static function Msg($type, $message)
  {

    $language = require CONF.'ini/language.php';

    $msg = '';

    if ($type == 0 or $type == 'error') {

      $msg = $language['error'][$message];

    } elseif ($type == 1 or $type == 'success') {
      $msg = $language['success'][$message];
    }

    return $msg;
  }

  public static function array_clear($array)
  {

    if ($array != []) {

      $new_array = array_filter($array, function ($element) {
        return !empty($element);
      });

      return $new_array;

    }

    return false;
  }

  public static function notFound($text = null)
  {
    http_response_code(404);

    $return = '<p style="margin-top:80px;margin-left:40px;font-size:55px;font-width:bold">';

    if ($text != null) {
      $return .= $text;
    } else {
      $return .= '404 page not found';
    }

    $return .= '</p>';

    exit($return);
  }

  public static function upperCamelCase($name)
  {
    return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
  }

  public static function lowerCamelCase($name)
  {
    return lcfirst(self::upperCamelCase($name));
  }

  /**
   * @return bool
   */
  public static function is_Ajax()
  {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
  }

  /**
   * @return bool
   */
  public static function is_Post()
  {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
  }

  /**
   * @return bool
   */
  public static function is_Get()
  {
    return $_SERVER['REQUEST_METHOD'] == 'GET';
  }

  public static function validString($string, $pattern)
  {
    return !preg_match('/^' . $pattern . '$/', $string);
  }

  public static function redirect($http = false)
  {

    if ($http) $redirect = $http;
    else $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : DOMEN;
    header("Location: $redirect");
    exit;
  }

}