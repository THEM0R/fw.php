<?php

namespace app\controllers;

use lib\App;

class MainController extends AppController
{

    public $title = ' Приватне Підприємство МЕТАЛІК-PLUS';



    public function indexAction($model, $route)
    {

        $title = 'МЕТАЛІК-PLUS |'.$this->title;

        $description = '';

        $this->meta($title,$description);

        $this->render(compact('description'));

    }



}