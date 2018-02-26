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

/*
 * Starting PHP session
 */
session_start();

$configuration = new Configuration();

$fastblog = new stdClass();
$fastblog->config = $configuration->getConfig();
$fastblog->databaseutils = new DatabaseUtils();
$fastblog->authentication = null;
$fastblog->basepath = BASE_PATH;

/*
 * Initializing MySQL PDO Connection Engine
 */
if($fastblog->config["mysql"]["host"] != ""){
    ORM::configure(array(
        'connection_string' => 'mysql:host='.$fastblog->config["mysql"]["host"].';port='.$fastblog->config["mysql"]["port"].';dbname='.$fastblog->config["mysql"]["db"],
        'username' => $fastblog->config["mysql"]["username"],
        'password' => $fastblog->config["mysql"]["password"],
        'driver_options' => array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ),
        'logging' => true,
        'caching' => false,
        'return_result_sets' => true
    ));
}
/*
 * Setup router
 */
$klein = new Klein();
/*
 * Add a title validator
 */
$klein->respond(function ($request, $response, $service) {
    $service->addValidator('string', function ($str) {
        return preg_match('/^[0-9a-z-]++$/i', $str);
    });
})->setCountMatch(false);
/*
 * Resource routing
 */
include SRC_PATH.'routes/resources/routes.php';
/*
 * Installation routing
 */
include SRC_PATH.'routes/install/routes.php';
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
 * Error handling
 */
$klein->onHttpError(function($code, $klein) use ($fastblog) {
    $service = $router->service();
    switch($code) {
        case 404: {
            $service->render(APP_PATH.'views/public/404.phtml', array('home' => $fastblog->config["domain"]));
        }
        break;
    }
});

$klein->dispatch();
