<?php

function pr6($arr)
{
    echo '<pre>' . print_r($arr, true) . '</pre>';
}

function pr7($arr)
{
    echo '<pre>' . print_r($arr, true) . '</pre>';
    exit;
}

function pr1($arr)
{
  dump($arr);

  //echo '<pre style="font-size: 18px;font-weight: bold;font-family: Tahoma">' . htmlspecialchars( print_r($arr, true) ). '</pre>';
  exit;
}

function pr($arr)
{

  dump($arr);
  //echo '<pre style="font-size: 18px;font-weight: bold;font-family: Tahoma">' . htmlspecialchars( print_r($arr, true) ). '</pre>';
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

