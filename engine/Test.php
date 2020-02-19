<?php


namespace engine;


class Test
{

    public static function test1(){
        echo 'test1';
        return new static();
    }

    public static function test2(){
        echo '<br>test2';
        return new static();
    }
    public function test3(){
        echo '<br>test3';
        return $this;
    }


}