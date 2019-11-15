<?php

namespace mvc;

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

    }


}