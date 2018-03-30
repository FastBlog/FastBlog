<?php
/**
 * FastBlog | routes.php
 * Routes file for the acp articles management
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

use \ORM;

$klein->with('/'.$fastblog->config["paths"]["admin"].'/articles/list', function () use($klein, $fastblog) {
    $klein->respond('', function ($request, $response, $service) use ($fastblog) {
        if ($fastblog->authentication->isAuthenticated()) {

            $n = 10; //Tmp value

            $articles = ORM::forTable('articles')->orderByAsc('id')->limit($n)->findArray();
            $service->render(APP_PATH . 'views/admin/articles/list/index.phtml', array(
                'articles' => $articles
            ));
        }
    });
});
