<?php
/**
 * FastBlog | routes.php
 * Routes file for the acp articles management
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

use \ORM;

$klein->with('/'.$fastblog->config["paths"]["admin"].'/articles/list', function () use($klein, $fastblog) {

    if ($fastblog->authentication->isAuthenticated()) {
        $klein->respond('', function ($request, $response, $service) use ($fastblog) {
            $n = 10; //TODO: Configurable value

            $articles = ORM::forTable('articles')->orderByAsc('id')->limit($n)->findArray();
            $service->render(APP_PATH . 'views/admin/acp/articles/list/index.phtml', array(
                'articles' => $articles
            ));
        });
    }

});
