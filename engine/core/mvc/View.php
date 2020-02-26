<? namespace mvc;

use engine\Engine;
use module\Helper;

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

  public function __construct($route, $theme = null, $view = null, $meta = [])
  {

    $this->route = $route;
    $this->controller = Helper::lowerCamelCase($route['controller']);
    $this->theme = $theme ?: THEME;
    $this->view = $view;
    //$this->script       = helper::$config['script'];
    $this->meta = $meta;
    // code

    $this->engine = new Engine();

    //pr1($this->engine->language);


    // unset optimize
    unset($route);
    unset($theme);
    unset($view);
    unset($meta);

  }


  public function rendering($vars)
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

    $file_view = APP . '/views/' . $this->theme . '/' . Helper::lowerCamelCase($this->view) . '.html';

    ob_start();

    if (is_file($file_view)) {
      require $file_view;
    } else {
      if (RELEASE) {
        Helper::NotFound();
      } else {

        $file = '';

        if (strpos($file_view, '/') !== false) {
          $file = ' ' . substr($file_view, strpos($file_view, '/'));
        }

        Helper::NotFound(msg(0, 2) . $file);
      }

    }

    // unset optimize
    unset($file_view);

    $content = ob_get_clean();

    //pr1($this->theme);

    if ($this->theme !== false) {

      $theme = APP . '/views/' . $this->theme . '/index.html';

      if (is_file($theme)) {
        require $theme;
      } else {
        Helper::NotFound(msg(0,2) .''. $theme);
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