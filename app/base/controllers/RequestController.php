<?php


namespace app\controllers;

use engine\Helper;

class RequestController extends AppController
{
  public function indexAction($model, $route)
  {

    pr2(HTTP_REFERER);
    pr1($route);
    Helper::redirect(DOMEN . '/' . LANGUAGE);
  }
}