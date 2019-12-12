<?php


namespace app\controllers;

use engine\Helper;

class MethodController extends AppController
{
    public function indexAction($model, $route)
    {
        pr1($route);
    }
}