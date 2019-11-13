<?php

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
        'int'  => '[0-9]+',
        'str'  => '[a-zA-Z\.\-_%]+',
        'all'  => '[a-zA-Z0-9\.\-_%]+'
    ];

    /**
     * @param $pattern
     * @param $route
     */
    public static function add($pattern, $route, $view = false)
    {

        if( is_string($route) )
        {
            if(strpos($route, ':') === false)
            {
                self::$routes[$pattern] = [
                    'controller' => $route,
                    'view'       => $view
                ];

            }else{
                $route = explode(':', $route);

                self::$routes[$pattern] = [
                    'controller'    => $route[0],
                    'action'        => $route[1],
                    'view'          => $view
                ];
            }

            unset($pattern);
            unset($route);
            unset($view);
        }
    }


    /**
     * @param $url
     * @return bool
     */
    protected static function getRoute($url)
    {

        foreach ( self::$routes as $pattern => $route )
        {

            $pattern = self::convertPattern( '#^'. $pattern . '$#i' );

            if( preg_match( $pattern, $url, $matches ) )
            {

                // unset optimize
                unset($pattern);
                unset($url);

                foreach ( $matches as $k => $v)
                {
                    if( is_string($k) ) {
                        $route[$k] = $v;
                    }
                }
                // unset optimize
                unset($matches);


                if( !isset($route['action']) )
                {
                    $route['action'] = 'index';
                }

                $route['controller'] = App::upperCamelCase( $route['controller'] );
                self::$route = $route;

                // unset optimize
                unset($route);


                return true;
            }
        }
        return false;
    }

    public static function Run()
    {
        if(  self::getRoute( rtrim($_SERVER['QUERY_STRING'], '/') ) ){

            $controller = 'app\\controllers\\'. self::$route['controller'] . 'Controller';
            if( class_exists($controller) ){

                // модель
                $model = 'app\\models\\' . self::$route['controller'] . 'Model';
                if( class_exists($model) ){
                    $modelObject = new $model( self::$route );

                    // unset optimize
                    unset($model);

                }else{
                    $modelObject = null;
                }

                $ControllerObject = new $controller($modelObject, self::$route);
                $action = App::lowerCamelCase( self::$route['action'] ).'Action';

                // unset optimize
                unset($controller);

                if( method_exists($ControllerObject, $action) ){

                    $ControllerObject->$action($modelObject, self::$route);
                    $ControllerObject->getView();

                    // unset optimize
                    unset($modelObject);
                    unset($ControllerObject);
                    unset($action);

                }else{
                    App::notFound();
                }

            }else{
                App::notFound();
            }

        }else{
            App::redirect('/');
        }
    }


    protected static function convertPattern($pattern)
    {   

        if(strpos($pattern, '(') === false)
        {
            return $pattern;
        }

        return preg_replace_callback('#\((\w+):(\w+)\)#', ['self','replacePattern'], $pattern);
    }

    protected static function replacePattern($matches)
    {
        return '(?<'.$matches[1].'>'.strtr($matches[2], self::$Patterns ).')';
    }

}