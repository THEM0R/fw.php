<?php

namespace mvc;
use core\DB;
use lib\App;

abstract class Model
{
    public $rb;

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

    public function __construct($route)
    {
        //pr1(Language::$ru);

        $this->rb = DB::instance();

        // route
        $this->route            = $route;

        $this->controller       = $route['controller'];
        $this->view             = $route['view'];

        // theme
        if(!$this->theme) $this->theme = THEME;

        // unset optimize
        unset($route);
    }


}