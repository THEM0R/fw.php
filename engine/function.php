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

function pr4($arr)
{
  echo '<pre style="font-size: 18px;font-weight: bold;font-family: Tahoma">' . htmlspecialchars( print_r($arr, true) ). '</pre>';
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

