<?php

$Router->get('admin', 'Admin','main')->name('home');
$Router->get('admin/(cat:all)', 'Admin:cat','cat');
