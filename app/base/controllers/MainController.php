<?php

namespace base\controllers;

use engine\Helper;

class MainController extends AppController
{

    public function indexAction($model, $route)
    {




      $this->getView();
      pr1($route);

        //exit();

//        echo "<form method='post' action='/posts1/asdsad/test12'>
//<input type='text' name='test1'>
//<input type='submit'>
//</form>";
//        pr1($route);
////        exit;
        //$this->render(compact(''));
    }

    public function testAction($model, $route)
    {
        pr1($route);
    }


    public function getAction($model, $route)
    {
        pr1($route);
    }

    public function viewAction($model, $route)
    {
        pr1($route);
    }

    public function viewsAction($model, $route)
    {
        pr1($route);
    }


}