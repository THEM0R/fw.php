<?php

require 'Router.php';

/* pages */

// test
Router::add('contact', 'main:contact','contact');
Router::add('prais', 'main:prais','prais');


// gallery
Router::add('gallery', 'gallery', 'gallery');

// about
Router::add('about', 'about','about');


// Material
Router::add('material', 'material', 'material');
Router::add('material/(product:all)', 'material:product','material_product');
//Router::add('material/(product:all)/(url:all)', 'material:view','material_view');

// metal
Router::add('metal', 'metal', 'metal');
Router::add('metal/prais', 'metal:prais','metal_prais');
Router::add('metal/(url:all)', 'metal:view','metal_view');





/* index */
Router::add('', 'main','main');
