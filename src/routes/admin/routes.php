<?php
/**
 * FastBlog | routes.php
 * Routes for the admin control panel
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

$klein->with('/'.$fastblog->config["paths"]["admin"], function () use($klein, $fastblog) {
    $fastblog->authentication = new ACPAuthentication($fastblog->config);

    $klein->respond('', function ($request, $response, $service) use($fastblog) {
        if($fastblog->authentication->isAuthenticated()) {
            $response->redirect('/' . $fastblog->config["paths"]["admin"] . '/dashboard');
        } else if($request->uri() === '/'.$fastblog->config["paths"]["admin"]){
            $response->redirect('/'.$fastblog->config["paths"]["admin"].'/login', 302);
        }
    });

    $klein->respond('/[:page]',function ($request, $response, $service) use($fastblog) {
        if($request->page !== 'login' && $request->page !== 'authentication'){
            if($fastblog->authentication->isAuthenticated()) {
                $service->render(
                    APP_PATH.'views/admin/acp/header.phtml',
                    array(
                        'username' => $_SESSION['username'],
                        'admin_path' => $fastblog->config["paths"]["admin"]
                    )
                );
                $submenu = APP_PATH.'views/admin/acp/'.$request->page.'/submenu.phtml';
                if(file_exists($submenu)) {
                    $service->render($submenu,
                        array(
                            "admin_path" => $fastblog->config["paths"]["admin"]
                        )
                    );
                }
            } else {
                $response->redirect('/'.$fastblog->config["paths"]["admin"].'/login', 302);
            }
        }
    });
});

include SRC_PATH.'routes/admin/articles/routes.php';

include SRC_PATH.'routes/admin/authentication/routes.php';

include SRC_PATH.'routes/admin/dashboard/routes.php';

include SRC_PATH.'routes/admin/ucp/routes.php';

include SRC_PATH.'routes/admin/users/routes.php';

if (file_exists(SRC_PATH.'routes/admin/custom/routes.php')) {
    include SRC_PATH.'routes/admin/custom/routes.php';
}
