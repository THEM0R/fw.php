<?php

function pr($arr)
{
    echo '<pre>' . print_r($arr, true) . '</pre>';
}

function pr1($arr)
{
    echo '<pre>' . print_r($arr, true) . '</pre>';
    exit;
}

function pr2($arr)
{
    echo '<pre>' , var_dump($arr) , '</pre>';
}

function pr3($arr)
{
    echo '<pre>' , var_dump($arr) , '</pre>';
    exit;
}

