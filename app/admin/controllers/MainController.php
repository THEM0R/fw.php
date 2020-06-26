<?php

namespace admin\controllers;

use base\controllers\AppController;

class MainController extends AppController
{

    private $test = [
        'test1' => 01,
        'test2' => 02,
        'test3' => 03,
    ];

    public function indexAction($model, $route)
    {

        $admin = 'SlavikMor';
        $admin2 = 'SlavikMor2';

        //pr1($this->c($admin));
        $this->renderTest($admin,$admin2);

        $this->render(compact('admin'));
    }


}