<?php
require_once __DIR__ . '/../engine/function.php';
require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../engine/config/define.php';

// Debug
// https://packagist.org/packages/symfony/debug
use Symfony\Component\Debug\Debug;
Debug::enable();
// Debug

$app = new \engine\Test();

$app->add('category')->first('film')->second('(url:22)')->last('cat');
$app->add('product')->first(11)->second(22)->last(33);
$app->add('homeController')->first(1)->second(2)->last(3);
$app->add('homes')->first(12)->second(23)->last(34);
$app->add('hom')->second(12)->first(23)->last(34);


pr1($app->getRoutes());

exit;


