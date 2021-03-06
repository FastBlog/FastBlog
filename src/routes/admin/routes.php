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

    $klein->respond('/[*:page]',function ($request, $response, $service) use($fastblog) {
        $page = explode ('/', $request->page)[0];
        if($page !== 'login' && $page !== 'authentication'){
            if($fastblog->authentication->isAuthenticated()) {
                $service->render(
                    APP_PATH.'views/admin/acp/header.phtml',
                    array(
                        'username' => $_SESSION['username'],
                        'admin_path' => $fastblog->config["paths"]["admin"]
                    )
                );
                $submenu = APP_PATH.'views/admin/acp/'.$page.'/submenu.phtml';
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

/*
 * Includes all the routes under 'src/routes/admin' recursively
 */
$adm_routes = SRC_PATH.'routes/admin/';
$adm_dir = scandir($adm_routes);

foreach($adm_dir as $adm_entry) {
    if (!in_array($adm_entry, array(".",".."))) {
        if (is_dir($adm_routes . $adm_entry)) {
            if (file_exists($adm_routes . $adm_entry . '/routes.php')) {
                include $adm_routes . $adm_entry . '/routes.php';
            }
        }
    }
}
