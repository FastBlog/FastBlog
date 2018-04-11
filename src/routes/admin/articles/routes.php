<?php
/**
 * FastBlog | routes.php
 * Routes file for the acp articles management
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

$klein->with('/'.$fastblog->config["paths"]["admin"].'/articles', function () use($klein, $fastblog) {

    if ($fastblog->authentication->isAuthenticated()) {
        $klein->respond('/delete/[i:id]', function ($request, $response, $service) use ($fastblog) {
            if ($fastblog->authentication->isAuthenticated()) {
                $service->render(APP_PATH . 'views/admin/acp/articles/delete/index.phtml'); //TODO: Send articles info to template
            }
        });
    }

});

include SRC_PATH . 'routes/admin/articles/new/routes.php';

include SRC_PATH . 'routes/admin/articles/edit/routes.php';

include SRC_PATH . 'routes/admin/articles/delete/routes.php';

include SRC_PATH . 'routes/admin/articles/list/routes.php';

