<?php

namespace app\controllers;
use mvc\Controller, lib\App;

class AppController extends Controller
{
    
    // app controller

    public function __construct($model, $route)
    {
        parent::__construct($model, $route);

        //pr($route);
    }
}