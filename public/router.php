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
$klein->respond(function ($request, $response, $service, $app) {
    $service->addValidator('string', function ($str) {
        return preg_match('/^[0-9a-z-]++$/i', $str);
    });
});

/*
 * Includes all the routes under 'src/routes' recursively
 */
$routes = SRC_PATH.'routes/';
$dir = scandir($routes);

foreach($dir as $routes_entry) {
    if (!in_array($routes_entry, array(".",".."))) {
        if (is_dir($routes . $routes_entry)) {
            if (file_exists($routes . $routes_entry . '/routes.php')) {
                include $routes . $routes_entry . '/routes.php';
            }
        }
    }
}

/*
 * Error handling
 */
$klein->onHttpError(function($code, $klein) use ($fastblog) {
    $service = $klein->service();
    switch($code) {
        case 404:
            $service->render(APP_PATH.'views/public/404.phtml', array('home' => $fastblog->config["domain"]));
            break;
        default:
            break;
    }
});

$klein->dispatch();
