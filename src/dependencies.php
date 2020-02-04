<?php

use Slim\App;


$container = $app->getContainer();

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ .'/../templates/', [
        'cache' => false
    ]);

// Instantiate and add Slim specific extension
$router = $container->get('router');
$uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
$view->addExtension(new Slim\Views\TwigExtension($router, $uri));
return $view;
};

//csrf
/*$container['csrf'] = function ($c) {
  return new \Slim\Csrf\Guard;
};*/

/* view renderer
    $container['view'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
        return new \Slim\Views\PhpRenderer($settings['template_path']);
    };*/



// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new \Monolog\Logger($settings['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

//  };

//Database Connection
/*$container['db'] = function () {
	try {
		$db = new PDO("sqlite:".__DIR__."../blog.db");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (Exception $e) {
		echo $e->getMessage();
		exit;
	}
	return $db;
};
*/

//API

/*$container['api'] = function ($c) {
  $api = $c->get('settings') ['api'];
  return $api;
};*/


//Database Connection
$container['db'] = function($c) {
    $db = $c->get('settings')['db'];
    $pdo = new PDO($db['dsn'].':'.$db['database']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};
