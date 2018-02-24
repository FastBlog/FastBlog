<?php
/**
 * FastBlog | routes.php
 * Routes file for the acp authentication logout
 * License: BSD-2-Clause
 */

$klein->respond('/'.$fastblog->config["paths"]["admin"].'/authentication/logout', function ($request, $response, $service) use($fastblog) {
    $result = $fastblog->authentication->isAuthenticated();

    if($result) {
        $fastblog->authentication->destroySession();
        $response->redirect('/'.$fastblog->config["paths"]["admin"].'/login?logout=1', 302);
    } else {
        $response->redirect('/'.$fastblog->config["paths"]["admin"].'/login', 302);
    }
});
