<?php
/**
 * FastBlog | routes.php
 * Routes file for the acp articles management
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

$klein->with('/'.$fastblog->config["paths"]["admin"].'/articles', function () use($klein, $fastblog) {
    $klein->respond(function ($request, $response, $service) use($fastblog) {
        if($fastblog->authentication->isAuthenticated()) {
            $service->render(
                APP_PATH.'views/admin/articles/submenu.phtml',
                array(
                    "admin_path" => $fastblog->config["paths"]["admin"]
                )
            );
        }
    });

    $klein->respond('', function ($request, $response, $service) use($fastblog) {
        if($fastblog->authentication->isAuthenticated()) {
            $service->render(APP_PATH.'views/admin/articles/index.phtml');
        }
    });

    $klein->respond('/list', function ($request, $response, $service) use($fastblog) {
        if($fastblog->authentication->isAuthenticated()) {
            $service->render(APP_PATH.'views/admin/articles/list/index.phtml');
        }
    });

    $klein->respond('/new', function ($request, $response, $service) use($fastblog) {
        if($fastblog->authentication->isAuthenticated()) {
            $service->render(APP_PATH.'views/admin/articles/new/index.phtml'); //TODO: Send articles info to template
        }
    });

    $klein->respond('/edit/[:id]', function ($request, $response, $service) use($fastblog) {
        if($fastblog->authentication->isAuthenticated()) {
            $service->render(APP_PATH.'views/admin/articles/edit/index.phtml'); //TODO: Send articles info to template
        }
    });

    $klein->respond('/delete/[:id]', function ($request, $response, $service) use($fastblog) {
        if($fastblog->authentication->isAuthenticated()) {
            $service->render(APP_PATH.'views/admin/articles/delete/index.phtml'); //TODO: Send articles info to template
        }
    });
});

include SRC_PATH.'routes/admin/articles/functions/routes.php';
