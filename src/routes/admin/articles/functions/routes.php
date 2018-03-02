<?php
/**
 * FastBlog | routes.php
 * Routes file for the acp articles management functions
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

use \ORM;

$klein->with('/'.$fastblog->config["paths"]["admin"].'/articles/list', function () use($klein, $fastblog) {
    $klein->respond('/', function ($request, $response, $service) use ($fastblog) {

        $n = 10; //tmp value
        $array = array();

        $articles = ORM::forTable('articles')->orderByAsc('id')->limit($n)->findMany();

        $i = 0;
        foreach($articles as $article) {
            $array[$i] = new Article($article->get('id'));
            $i++;
        }

        if ($article) {
            $service->render(APP_PATH . 'views/admin/articles/list/index.phtml', array(
                "articles" => $array
            ));
        } else {
            $service->redirect($fastblog->config["paths"]["admin"].'/articles', 302);
        }
    });
});

include SRC_PATH.'routes/admin/articles/functions/new/routes.php';

include SRC_PATH.'routes/admin/articles/functions/edit/routes.php';

include SRC_PATH.'routes/admin/articles/functions/delete/routes.php';
