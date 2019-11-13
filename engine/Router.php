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
        if($pattern == ''){

            $pattern = '(language:str)'.$pattern;

        }else{

            $pattern = '(language:str)/'.$pattern;
        }

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
            pr1($url);

            $PATTERN = '#^'. $pattern . '$#i';
            $pattern = self::convertPattern( $PATTERN );
            //



            if( preg_match( $pattern, $url, $matches ) )
            {

                foreach ( $matches as $k => $v)
                {
                    if( is_string($k) )
                    {
                        $route[$k] = $v;
                    }
                }

                if( isset($route['language']) ) {

                    if (!in_array($route['language'], ['ua', 'ru'])) {
                        Helper::notFound();
                    }else{
                        $_SESSION[LANG] = $route['language'];
                    }

                }else{
                    Helper::notFound();
                }


                if( !isset($route['action']) )
                {
                    $route['action'] = 'index';
                }



                $route['controller'] = Helper::upperCamelCase( $route['controller'] );
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    public static function Run($url)
    {


//        if( $url == false ){
//
//            //pr1($_SESSION[LANGUAGE]);
//
//            Helper::redirect(DOMEN.'/'.$_SESSION[LANG]);
//        }
//
//
//
//        // if GET
//        if( Helper::is_Get($url) ){
//            $url = explode('&',$url)[0];
//        }



        //
        if( self::getRoute($url) ){

            pr1($url);

            $controller = 'app\\controllers\\'. self::$route['controller'] . 'Controller';

            if( class_exists($controller) ){

                // модель
                $model = 'app\\models\\' . self::$route['controller'] . 'Model';

                if( class_exists($model) ){
                    $modelObject = new $model( self::$route );
                }else{
                    $modelObject = false;
                }

                $ControllerObject = new $controller( $modelObject, self::$route );

                $action = Helper::lowerCamelCase( self::$route['action'] ).'Action';

                if( method_exists($ControllerObject, $action) ){

                    $ControllerObject->$action( $modelObject, self::$route );

                    $ControllerObject->getView();

                }else{
                    Helper::notFound();
                }

            }else{
                Helper::notFound();
            }

        }else{
            Helper::notFound();
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