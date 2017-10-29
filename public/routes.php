<?php
/**
 * Routes core and initialization.
 * User: HexelDev
 */
namespace HexelDev\FastBlog;

use HexelDev\Core\Article;
use HexelDev\Core\ArticlesLoaderUtils;
use HexelDev\Core\FileLoader;
use Klein\Klein;
use \ORM, \PDO;
use \Twig_Environment, \Twig_Loader_Filesystem;
use HexelDev\Core\Configuration;

require_once __DIR__ . '../vendor/autoload.php';

/*
* MySQL PDO Connection Engine
*/
ORM::configure(array(
    'connection_string' => 'mysql:host='.Configuration::$MYSQL_HOST.';port='.Configuration::$MYSQL_PORT.';dbname='.Configuration::$MYSQL_DB,
    'username' => Configuration::$MYSQL_USER,
    'password' => Configuration::$MYSQL_PASSWORD,
    'driver_options' => array(
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ),
    'logging' => true,
    'caching' => false
));

/*
 * Setup routes and template handler
 */
$klein = new Klein();
$twig = new Twig_Environment(new Twig_Loader_Filesystem('../app/views'));

$service->addValidator('title', function ($str) {
    return preg_match('/([A-Z1-9a-z-])/g', $str);
});

$klein->respond('/[*:title]', function ($request, $response, $service) {
    $service->validateParam('title')->isTitle();
    if(file("../app/views/" + $request->title + ".html").exist) {
        $previews = (new ArticlesLoaderUtils())->getLastXArticles(Configuration::$LAST_ARTICLES_PREVIEW_NUMBER);
        $previews->count();
        $response->body($twig->render( $request->title + ".html", array(
            //First x articles passed on every page
        )));
    }
});

$klein->respond('/article/[i:year]/[i:month]/[*:title]', function ($request, $response, $service) {
    $service->validateParam('year')->isInt();
    $service->validateParam('month')->isInt();
    $service->validateParam('title')->isTitle();

    $article = new Article($request->year, $request->month, $request->title);
    if($article->exist()) {
        $response->body($twig->render('article.html', array(
            'p_day' => $article->getDay(),
            'p_month' => $article->getMonth(),
            'p_year' => $article->getYear(),
            'title' => $article->getTitle(),
            'body' => $article->getBody(),
            'social' => $article->getSocial()
        )));
    } else {
        $response->body($twig->render('404.html', array(
            'home' => Configuration::$HOME_PATH
        )));
    }
});

$klein->dispatch();