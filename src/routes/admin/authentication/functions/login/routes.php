<?php
/**
 * FastBlog | routes.php
 * Routes file for the acp authentication login
 * License: BSD-2-Clause
 */

$klein->respond('POST', '/'.$fastblog->config["paths"]["admin"].'/authentication/login', function ($request, $response, $service) use($fastblog) {
    try {
        $service->validateParam('email')->isEmail();

        $result = $fastblog->authentication->comparePassword($request->email, $request->password);

        if($result) {
            $user = ORM::forTable('admin')->where(
                array(
                    'email' => $request->email
                )
            )->findOne();
            if($user) {
                $fastblog->authentication->createSession($user->get('id'), $request->rememberme);
                $response->redirect('/'.$fastblog->config["paths"]["admin"].'/dashboard', 302);
            }
        } else {
            $response->redirect('/'.$fastblog->config["paths"]["admin"].'/login?error=1', 302);
        }
    } catch (\Klein\Exceptions\ValidationException $e) {
        $response->redirect('/'.$fastblog->config["paths"]["admin"].'/login?error=1', 302);
    }
});

$klein->respond('GET', '/'.$fastblog->config["paths"]["admin"].'/authentication/login', function ($request, $response, $service) use($fastblog) {
    if($fastblog->authentication->isAuthenticated()) {
        $response->redirect('/' . $fastblog->config["paths"]["admin"] . '/dashboard');
    } else if($request->uri() === '/'.$fastblog->config["paths"]["admin"]){
        $response->redirect('/'.$fastblog->config["paths"]["admin"].'/login', 302);
    }
});
