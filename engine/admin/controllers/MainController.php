<?php

namespace engine\admin\controllers;
use app\controllers\AppController;

class MainController extends AppController
{

    public function indexAction($model, $route){

        echo 'admin';
//        /pr1($route);

        $admin = 'SlavikMor';

        $this->render(compact('admin'));
    }

}