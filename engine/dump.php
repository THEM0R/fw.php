<?php

function pr6($arr = null)
{
  echo '<pre>' . print_r($arr, true) . '</pre>';
}

function pr7($arr = null)
{
  echo '<pre>' . print_r($arr, true) . '</pre>';
  exit;
}

function pr1($arr = null)
{
  dump($arr);

  //echo '<pre style="font-size: 18px;font-weight: bold;font-family: Tahoma">' . htmlspecialchars( print_r($arr, true) ). '</pre>';
  exit;
}

function pr($arr = null)
{

  dump($arr);
  //echo '<pre style="font-size: 18px;font-weight: bold;font-family: Tahoma">' . htmlspecialchars( print_r($arr, true) ). '</pre>';
}

function pr2($arr = null)
{
  echo '<pre>', var_dump($arr), '</pre>';
}

function pr3($arr = null)
{
  echo '<pre>', var_dump($arr), '</pre>';
  exit;
}
