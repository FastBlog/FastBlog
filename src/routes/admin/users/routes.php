<?php
/**
 * FastBlog | routes.php
 * Routes file for the acp users configuration
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

$klein->with('/'.$fastblog->config["paths"]["admin"].'/users', function () use($klein, $fastblog) {
    $klein->respond('', function ($request, $response, $service) use($fastblog) {
        if($fastblog->authentication->isAuthenticated()) {
            $service->render(APP_PATH.'views/admin/acp/users/index.phtml');
        }
    });
});
