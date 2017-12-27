<?php
/**
 * FastBlog | router.php
 * Router core and initialization
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

use \Klein\Klein, \ORM, \PDO, \stdClass;

define('BASE_PATH', dirname(__DIR__).'/');
define('SRC_PATH', BASE_PATH.'src/');
define('APP_PATH', BASE_PATH.'app/');
define('STORAGE_PATH', BASE_PATH.'storage/');

require_once (SRC_PATH.'core/autoloader.php');
$configuration = new Configuration();

$fastblog = new stdClass();
$fastblog->config = $configuration->getConfig();
$fastblog->articlefactory = new ArticleFactory();
$fastblog->databaseutils = new DatabaseUtils();

/*
 * Initializing MySQL PDO Connection Engine
 */
ORM::configure(array(
    'connection_string' => 'mysql:host='.$fastblog->config["mysql"]["host"].';port='.$fastblog->config["mysql"]["port"].';dbname='.$fastblog->config["mysql"]["db"],
    'username' => $fastblog->config["mysql"]["username"],
    'password' => $fastblog->config["mysql"]["password"],
    'driver_options' => array(
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ),
    'logging' => true,
    'caching' => false
));

/*
 * Setup router
 */
$klein = new Klein();
/*
 * Redirect every validation error/every error to the 404 page
 */
$klein->onError(function ($klein, $message) use ($fastblog) {
    $service = $klein->service();
    $config = $fastblog->config;
    $service->render(APP_PATH.'views/404.phtml', array('home' => $config["domain"]));
});
/*
 * Add a title validator
 */
$klein->respond(function ($request, $response, $service) {
    $service->addValidator('string', function ($str) {
        return preg_match('/^[0-9a-z-]++$/i', $str);
    });
});
/*
 * Article routing
 */
include SRC_PATH.'routes/blog/routes.php';
/*
 * Blog routing
 */
include SRC_PATH.'routes/pages/routes.php';
/*
 * Admin routing
 */
include SRC_PATH.'routes/admin/routes.php';
/*
 * Resource routing
 */
include SRC_PATH.'routes/resources/routes.php';
/*
 * Installation routing
 */
include SRC_PATH.'routes/install/routes.php';
/*
 * Error handling
 */
$klein->onHttpError(function($code, $klein) use ($fastblog) {
    $request = $klein->request();
    $response = $klein->response();
    $service = $klein->service();
    $config = $fastblog->config;
	if (!$response->useCustomErrors()) {
        return;
    }
    switch($code) {
        case '404': {
            if ($request->method('get')) {
                $service->render(APP_PATH.'views/404.phtml', array('home' => $config["domain"]));
            }
        }
            break;
    }
});

$klein->dispatch();