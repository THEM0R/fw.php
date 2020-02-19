<?php


namespace engine;

require_once __DIR__ . '/config/define.php';


class Router
{

    public function __construct()
    {
        $this->url = $this->getUrl();
    }

    private $url;

    /**
     * @var $routes
     * масив роутов
     */
    protected $routes = [];
    protected $routeName;

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
     * @param $pattern
     * @return string
     */
    private function pattern($pattern)
    {
        if (SL) {
            if ($pattern == '') {
                $pattern = '(language:str)' . $pattern;
            } else {
                $pattern = '(language:str)/' . $pattern;
            }
        }
        return $pattern;
    }


    /**
     * @param $regex
     * @param $controller
     * @param bool $function
     * @param bool $view
     * @return $this
     */
    public function get($regex, $controller, $function = false, $view = false)
    {
        $this->addRoute($regex, $controller, $view, 'GET', $function);
        return $this;
    }


    /**
     * @param $regex
     * @param $controller
     * @param bool $function
     * @param bool $view
     * @return $this
     */
    public function post($regex, $controller, $function = false, $view = false)
    {
        $this->addRoute($regex, $controller, $view, 'POST', $function);
        return $this;
    }

    public function name($name = '')
    {

        //pr1($this->routeName);

        $this->routes[$this->routeName]['name'] = $name;
        return $this;
    }

    /**
     * @param $pattern
     * @param $route
     * @param bool $view
     * @param string $method
     * @param bool $function
     */
    public function addRoute($pattern, $route, $view = false, $method = 'GET', $function = false)
    {
        if (is_string($route)) {

            $pattern = $this->pattern($pattern);

            $this->routeName = $pattern;

            if (strpos($route, ':') === false) {

                $this->routes[$pattern] = [
                    'controller' => $route,
                    'view' => $view,
                    'method' => ['name' => $method],
                    'function' => $function
                ];

            } else {

                $route = explode(':', $route);

                $this->routes[$pattern] = [
                    'controller' => $route[0],
                    'action' => $route[1],
                    'view' => $view,
                    'method' => ['name' => $method],
                    'function' => $function
                ];
            }
        } // is_string
    }

    /**
     * addRequestParameters
     */
    private function addRequestParameters()
    {
        if ($_GET !== []) {
            $url = '?';
            foreach ($_GET as $key => $value) {
                $url .= $key . '=' . $value . '&';
            }
            $url = rtrim($url, '&');

            Helper::redirect(DOMEN . '/' . LANGUAGE . '/' . $url);
        }
    }

    /**
     * @param $url
     * SEVERAL LANGUAGES -- РІЗНІ МОВИ
     */
    private function SeveralLanguages($url)
    {

        if (SL) { // SEVERAL_LANGUAGES -- РІЗНІ МОВИ

            /** якшо в $url пусто */
            if ($url === '') {
                $this->addRequestParameters();
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


        } else { // SEVERAL_LANGUAGES -- РІЗНІ МОВИ


            if (in_array(substr($url, 0, 2), LANGUAGES)) {

                $url = substr($url, 2);

                if (strpos($url, '/') === 0) {
                    $url = substr($url, 1);
                }
                Helper::redirect(DOMEN . '/' . $url);
            }
        }
    }


    /**
     * SERVER REQUEST_METHOD
     */
    private function requestMethod()
    {
        if ($this->route['method']['name'] !== $_SERVER['REQUEST_METHOD']) {
            Helper::notFound('REQUEST_METHOD не співпадає');
        }
        if ($this->route['method']['name'] == 'GET') {
            $this->route['method']['data'] = Helper::array_clear($_GET);
        } else if ($this->route['method']['name'] == 'POST') {
            $this->route['method']['data'] = Helper::array_clear($_POST);
        }
    }

    public function getUrl()
    {
        $url = trim($_SERVER['REQUEST_URI']);

        $pos = strpos($_SERVER['REQUEST_URI'], '?');

        if ($pos) {
            $url = substr($_SERVER['REQUEST_URI'], 0, $pos);
        }

        $url = trim($url, '/');

        return $url;
    }



    /**
     * @START PROGRAM
     */
    public function Run()
    {
        $this->severalLanguages($this->url);

        if ($this->getRoute($this->url)) {

            //pr3($this->route['function']);

            //$this->route['function']->__invoke();

            $this->requestMethod();

            $controller = 'app\\controllers\\' . $this->route['controller'] . 'Controller';

            if (class_exists($controller)) {

                // модель
                $model = 'app\\models\\' . $this->route['controller'] . 'Model';
                if (class_exists($model)) {
                    $modelObject = new $model($this->route);

                    // unset optimize
                    unset($model);

                } else {
                    $modelObject = null;
                }

                $ControllerObject = new $controller($modelObject, $this->route);
                $action = Helper::lowerCamelCase($this->route['action']) . 'Action';

                // unset optimize
                //unset($controller);

                if (method_exists($ControllerObject, $action)) {

                    $ControllerObject->$action($modelObject, $this->route);
                    $ControllerObject->getView();

                    // unset optimize
                    unset($modelObject);
                    unset($ControllerObject);
                    //unset($action);

                } else {
                    Helper::notFound('no method in ' . $controller . ' ' . $action);
                }

            } else {
                Helper::notFound('no controller ' . $controller);
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
        return preg_replace_callback("#\((\w+):(\w+)\)#", [$this,'replacePattern'], $pattern);
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

    /**
     * @param $url
     * redirect to request
     */
    private function request($url)
    {

        pr1($url);

        if (strpos($url, '/') !== false) {


            if (strpos($url, '&') !== false) {

                $url_request = explode('&', $url)[0];
                $url = explode('&', $url)[1];

                pr1($url_request);
            }
        }


        if (strpos($url, '&') !== false | strpos($url, '=') !== false) {
            if (strpos($url, 'request') === false) {
                if (SL) {
                    if (!in_array(explode('/', $url)[1], LANGUAGES)) {
                        $url = explode('/', $url)[1];
                    }
                }

                if (strpos($url, '&') === 0) {
                    $url = substr($url, 1);
                }

                Helper::redirect(DOMEN . '/request/' . '&' . $url);
            }
        }
    }

}