<?php
use engine\Router;
/* search */
Router::add('speed/search','search:speed',false);

/* parser */
Router::add('parser', 'parser');
Router::add('parser/link', 'parser:link');
Router::add('parser/form', 'parser:form');

Router::add('parser/index', 'parser:parsing');

/* admin */
Router::add('admin/addposter', 'admin:addPoster');

Router::add('admin/add/film', 'admin:FormAddFilm','addfilm');
Router::add('admin/add/film/action', 'admin:AddFilm');

Router::add('admin/add', 'admin:adding','adding');
/* edit */
Router::add('(category:str)/(url:all)/edit', 'edit:movieEdit');

/* parser KP */
Router::add('admin/kinopoisk/film', 'kinopoisk','kinopoisk');
Router::add('admin/kinopoisk/film/form', 'kinopoisk:Form',false);
Router::add('admin/kinopoisk/film/poster', 'kinopoisk:PosterRequest',false);
Router::add('admin/kinopoisk/film/screen', 'kinopoisk:ScreenRequest',false);
Router::add('admin/kinopoisk/film/add', 'kinopoisk:AddFilm',false);

/* parser my-hit.org */
Router::add('admin/my-hit/film', 'myhit','myhit');
Router::add('admin/my-hit/film/link', 'myhit:link', false);
Router::add('admin/my-hit/film/form', 'myhit:form', false);
Router::add('admin/my-hit/film/poster', 'myhit:poster', false);
Router::add('admin/my-hit/film/screen', 'myhit:screen', false);
Router::add('admin/my-hit/film/add', 'myhit:add', false);



/* upload */
Router::add('upload/image/ajax', 'upload:uploadImageAjax');
Router::add('upload/image/url', 'upload:urlToBase64');
Router::add('upload/delete/image', 'upload:deleteImage');
Router::add('upload/image', 'upload:test');

/* sorting */
Router::add('sorting', 'sorting:sort', false);
Router::add('sorting/view', 'sorting:sortView', false);


/* user */
Router::add('user', 'user', 'users');
Router::add('user/(url:all)', 'user:view', 'user');
Router::add('user/(url:all)/favorite', 'user:favorite');

/* auth */
Router::add('singin', 'auth:singin', false);
Router::add('singup', 'auth:singup', false);
Router::add('logout', 'auth:logout', false);
Router::add('singin/valid', 'auth:singinValid',false);
Router::add('singup/validname', 'auth:singupValidName', false);
Router::add('singup/validemail', 'auth:singupValidEmail', false);

/* stars */
Router::add('star', 'stars');
Router::add('star/(url:str)', 'stars:view');

/* pages */
Router::add('page/(url:str)', 'pages');

/* favorites */
Router::add('favorite/add', 'favorite:add');
Router::add('favorite/dell', 'favorite:dell');

/* view */
Router::add('(category:str)/(url:all)', 'view:index','view');
Router::add('(category:str)/(url:all)/(action:str)', 'View');

/* category */
Router::add('(category:str)', 'category','category');
Router::add('(category:str)/page/(page:int)', 'category');



/* index */
Router::add('', 'Main','main');
