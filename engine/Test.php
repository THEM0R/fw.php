<?php


namespace engine;


class Test
{

    public $first;
    public $second;
    public $last;

    public $route;
    public $routes = [];

    public function add($route){
        $this->route = $route;
        return $this;
    }

    public function first($name = ''){
        $this->routes[$this->route]['first'] = $name;
        return $this;
    }

    public function second($name = ''){
        $this->routes[$this->route]['second'] = $name;
        return $this;
    }
    public function last($name = ''){
        $this->routes[$this->route]['last'] = $name;
        return $this;
    }

    public function getRoutes(){
        return $this->routes;
    }



}