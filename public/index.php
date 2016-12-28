<?php
// require_once __DIR__.'/../vendor/autoload.php';

// $app = new Silex\Application();

// $app->register(new Silex\Provider\SessionServiceProvider());

// $app->register(new Silex\Provider\TwigServiceProvider(), array(
//     'twig.path' => __DIR__.'/../views',
// ));

// $app->register(new Silex\Provider\DoctrineServiceProvider(), array(
//     'db.options' => array (
//             'driver'    => 'pdo_mysql',
//             'host'      => 'localhost',
//             'dbname'    => 'scotchbox',
//             'user'      => 'root',
//             'password'  => 'root',
//             'charset'   => 'utf8mb4',
// )));

// //$app->mount('/blog', include __DIR__.'/../app/blog.php');
// $app->mount('/blog', new Acme\HelloControllerProvider());

// $app['debug'] = true;

// $app->run();

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

require __DIR__.'/../app/config/dev.php';
require __DIR__.'/../app/app.php';
require __DIR__.'/../app/routes.php';

$app->run();
