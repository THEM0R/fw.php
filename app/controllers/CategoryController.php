<?php

namespace app\controllers;

use engine\Helper;

class CategoryController extends AppController
{

  public function indexAction($model, $route)
  {
    $this->getView();
    pr1($route);

  }

  public function testAction($model, $route)
  {
    pr1($route);
  }


  public function getAction($model, $route)
  {
    pr1($route);
  }


}