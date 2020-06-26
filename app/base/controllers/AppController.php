<?php

namespace app\controllers;

use mvc\Controller;

class AppController extends Controller
{
    
    // app controller

    public function __construct($model, $route)
    {
        parent::__construct($model, $route);

        //pr1($route);
    }
}