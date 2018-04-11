<?php
/**
* FastBlog | routes.php
* Routes file for the acp dashboard
* License: BSD-2-Clause
*/
namespace FastBlog\Core;

$klein->with('/'.$fastblog->config["paths"]["admin"].'/dashboard', function () use($klein, $fastblog) {

    if($fastblog->authentication->isAuthenticated()) {
        $klein->respond('', function ($request, $response, $service) use($fastblog) {
            if($request->uri() === '/'.$fastblog->config["paths"]["admin"].'/dashboard'){
                $service->render(APP_PATH.'views/admin/acp/dashboard/index.phtml');
            }
        });

        $klein->respond('/configuration', function ($request, $response, $service) use($fastblog) {
            if($fastblog->authentication->isAuthenticated()) {
                $service->render(APP_PATH.'views/admin/acp/dashboard/configuration/edit/index.phtml'); //TODO: Send config values to template
            }
        });

        $klein->respond('/external', function ($request, $response, $service) use($fastblog) {
            $service->render(APP_PATH.'views/admin/acp/dashboard/external/index.phtml'); //TODO: Send external resources settings to template
        });
    }

});
