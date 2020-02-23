<?php


namespace engine;


class Engine
{
    public $language = [];

    public function __construct()
    {

        //pr1(CONF);

        $this->language = require_once CONF.'/ini/language.php';
    }
}