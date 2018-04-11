<?php
/**
 * FastBlog | routes.php
 * Routes file for the acp user panel
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

$klein->with('/'.$fastblog->config["paths"]["admin"].'/ucp', function () use($klein, $fastblog) {

    if($fastblog->authentication->isAuthenticated()) {
        $klein->respond('', function ($request, $response, $service) use($fastblog) {
            if($request->uri() === '/'.$fastblog->config["paths"]["admin"].'/ucp') {
                $service->render(APP_PATH . 'views/admin/acp/ucp/index.phtml');
            }
        });
    }

});
