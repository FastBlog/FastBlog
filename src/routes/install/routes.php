<?php
/**
 * FastBlog | routes.php
 * //File description
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

$klein->respond('/setup/configuration', function ($request, $response, $service) use($fastblog) {
    $config = $fastblog->config;
    if(file_exists(BASE_PATH.'install/')) {
        $service->render(BASE_PATH . 'install/configuration.phtml');
    } else {
        $service->render(APP_PATH.'views/public/404.phtml', array('home' => $config["domain"]));
    }
});

$klein->respond('/setup/confirmation', function ($request, $response, $service) use($fastblog) {
    $config = $fastblog->config;
    if(file_exists(BASE_PATH.'install/')) {
        if($request->method('post')) {
            $service->render(BASE_PATH . 'install/confirmation.phtml');
        } else {
            $service->render(BASE_PATH . 'install/configuration.phtml');
        }
    } else {
        $service->render(APP_PATH.'views/public/404.phtml', array('home' => $config["domain"]));
    }
});

$klein->respond('/setup/installation', function ($request, $response, $service) use($fastblog) {
    $config = $fastblog->config;
    if(file_exists(BASE_PATH.'install/')) {
        if($request->method('post')) {
            $service->render(BASE_PATH . 'install/installation.phtml');
        } else {
            $service->render(BASE_PATH . 'install/configuration.phtml');
        }
    } else {
        $service->render(APP_PATH.'views/public/404.phtml', array('home' => $config["domain"]));
    }
});