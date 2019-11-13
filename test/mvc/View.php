<? namespace mvc;

use lib\App;
use lang\Language;

class View
{
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

        $this->route        = $route;
        $this->controller   = App::lowerCamelCase($route['controller']);
        $this->theme        = $theme ?: THEME;
        $this->view         = $view;
        $this->script       = App::$config['script'];
        $this->meta         = $meta;
        // code

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
        $vars = array_merge($all,$vars);

        // unset optimize
        unset($script);
        unset($all);

        if($this->view == false) App::NotFound();

        if(is_array($vars)) extract($vars);

        // unset optimize
        unset($vars);

        $file_view = APP .'/views/'.$this->theme.'/'.App::lowerCamelCase($this->view).'.html';

        ob_start();

        if( is_file($file_view) ){ require $file_view; }else{ App::NotFound(); }

        // unset optimize
        unset($file_view);

        $content = ob_get_clean();

        if( false !== $this->theme )
        {

            $file_theme = APP .'/views/'.$this->theme.'/index.html';

            if( is_file($file_theme) )
            {
                require $file_theme;

            }else{
                App::NotFound();
            }

            // unset optimize
            unset($file_theme);

        }else{

            App::NotFound();
        }
    }

    public function require_pro($file){
        if(is_file($file)) require ($file);
    }
}