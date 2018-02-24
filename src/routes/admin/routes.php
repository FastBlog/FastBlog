<?php
/**
 * FastBlog | routes.php
 * //File description
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

$klein->with('/'.$fastblog->config["paths"]["admin"], function () use($klein, $fastblog) {
    $klein->respond(function () use($fastblog) {
        $fastblog->authentication = new ACPAuthentication($fastblog->config);
    });

    $klein->respond('', function ($request, $response, $service) use($fastblog) {
        if($fastblog->authentication->isAuthenticated()) {
            $response->redirect('/' . $fastblog->config["paths"]["admin"] . '/dashboard');
        }
    });

    $klein->respond('!@^(/login|/authentication)',function ($request, $response, $service) use($fastblog) {
        if($fastblog->authentication->isAuthenticated()) {
            $service->render(
                APP_PATH.'views/admin/header.phtml',
                array(
                    'username' => $_SESSION['username'],
                    'admin_path' => $fastblog->config["paths"]["admin"]
                )
            );
        } else {
            $response->redirect('/'.$fastblog->config["paths"]["admin"].'/login', 302);
        }
    });
});

include SRC_PATH.'routes/admin/articles/routes.php';

include SRC_PATH.'routes/admin/authentication/routes.php';

include SRC_PATH.'routes/admin/dashboard/routes.php';

include SRC_PATH.'routes/admin/ucp/routes.php';

include SRC_PATH.'routes/admin/users/routes.php';
