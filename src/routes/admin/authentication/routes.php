<?php
/**
 * FastBlog | routes.php
 * Routes file for the acp authentication
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;
use \ORM;


$klein->respond('GET', '/'.$fastblog->config["paths"]["admin"].'/login', function ($request, $response, $service) use($fastblog) {
    if(!$fastblog->authentication->isAuthenticated()) {
        /*ORM::forTable('admin')->create(array(
            'nickname' => 'admin',
            'email' => 'test@test.test',
            'password' => password_hash('admin', PASSWORD_DEFAULT)
        ))->save();*/
        $service->render(APP_PATH.'views/admin/authentication/login.phtml',
            array(
                "admin_path" => $fastblog->config["paths"]["admin"]
            )
        );
    } else {
        $response->redirect('/'.$fastblog->config["paths"]["admin"].'/dashboard', 302);
    }
});

include SRC_PATH.'routes/admin/authentication/functions/routes.php';
