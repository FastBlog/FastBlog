<?php
/**
 * FastBlog | router.php
 * Routes core and initialization
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

use Klein\Klein;
use \ORM, \PDO;

require_once __DIR__ . '../vendor/autoload.php';

$config = include(SRC_PATH.'core/configuration.php');

define('BASE_PATH', dirname(__DIR__).'/');
define('SRC_PATH', BASE_PATH.'src/');
define('APP_PATH', BASE_PATH.'app/');
define('STORAGE_PATH', BASE_PATH.'storage/');

/*
 * MySQL PDO Connection Engine
 */
ORM::configure(array(
    'connection_string' => 'mysql:host='.$config["mysql"]["host"].';port='.$config["mysql"]["port"].';dbname='.$config["mysql"]["db"],
    'username' => $config["mysql"]["username"],
    'password' => $config["mysql"]["password"],
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
 * Setup a title validator
 */
$service->addValidator('title', function ($str) {
    return preg_match('/([A-Z1-9a-z-])/g', $str);
});

/*
* @TODO create a routing file for every situation
*/

/*
* Public blog pages routing
*/
include SRC_PATH.'routes/pages/routes.php';

/*
* Article routing
*/
include SRC_PATH.'routes/blog/routes.php';

/*
* @TODO Admin routing
*/

/*
* @TODO Resource routing
*/

/*
* @TODO Installation routing
*/

$klein->dispatch();
