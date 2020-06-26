<? namespace mvc;

use engine\Engine;
use module\Helper;

use router\Router;

class View
{

  private $engine;

  public $meta = [];

  public $controller;

  public $script = [];

  /*
   * @array $route
   * текущий маршрут
   */
  public $route = [];

  /*
   * @var $view
   * текущий вид
   */
  public $view;

  /*
   * @var $templates
   * текущий шаблон
   */
  public $theme;


  public $routes = [];



  public function __construct($route, $theme = null, $view = null, $meta = [])
  {

    $routes = new Router();

    $this->routes = $routes->getRoutes();

    $this->route = $route;
    $this->controller = Helper::lowerCamelCase($route['controller']);
    $this->theme = $theme ?: THEME;
    $this->view = $view;
    //$this->script       = helper::$config['script'];
    $this->meta = $meta;
    // code

//    /$this->engine = new Engine();

    //pr1($this->engine->language);


    // unset optimize
    unset($route);
    unset($theme);
    unset($view);
    unset($meta);

  }


  public function rendering($directory, $vars)
  {

    $script = $this->script;
    $all = compact('script');
    $vars = array_merge($all, $vars);

    // unset optimize
    unset($script);
    unset($all);

    if ($this->view == false) {
      if (RELEASE) {
        Helper::NotFound();
      } else {
        Helper::NotFound(msg(0, 1));
      }
    }


    if (is_array($vars)) extract($vars);

    // unset optimize
    unset($vars);

    $view = $directory . '/views/' . $this->theme . '/' . Helper::lowerCamelCase($this->view) . '.html';

    ob_start(); // старт буферизации

    if (is_file($view)) {
      require $view;
    } else {
      if (RELEASE) {
        Helper::NotFound();
      } else {
        if (strpos($view, '/') !== false) {
          $view = ' ' . substr($view, strpos($view, '/'));
        }
        Helper::NotFound(msg(0, 2) . $view);
      }

    }

    // unset optimize
    unset($view);

    $content = ob_get_clean();

    if ($this->theme !== false) {

      $theme = $directory . '/views/' . $this->theme . '/index.html';

      if (is_file($theme)) {
        require $theme;
      } else {

        if (RELEASE) {
          Helper::NotFound();
        } else {
          if (strpos($theme, '/') !== false) {
            $theme = ' ' . substr($theme, strpos($theme, '/'));
          }
          Helper::NotFound(msg(0, 2) . $theme);
        }
      }
      // unset optimize
      unset($theme);

    } else {
      Helper::NotFound('theme === false');
    }
  }

  public function require_pro($file)
  {
    if (is_file($file)) require($file);
  }
}