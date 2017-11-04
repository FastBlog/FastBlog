<?php
/**
 * FastBlog | routes.php
 * Routes file for the public pages requests
 * License: BSD-2-Clause
 */

namespace FastBlog\Core;

use FastBlog\Core\Article;

$klein->respond('/[*:title]', function ($request, $response, $service) {
    $service->validateParam('title')->isTitle();
    if(file(APP_PATH.'views/' . $request->title . '.phtml').exist) {
        $config = include(SRC_PATH.'core/configuration.php');
        $array = array(

        );

        if(in_array($request->title + '.phtml', $config["options"]["article_preview_allowed_pages"])){
            $loaderutil = new LoaderUtils();
            $previews = $loaderutil->getLastXArticles($config["options"]["latest_articles_preview_number"]);
            $array['latests'] = $previews;
        }

        $service->render(APP_PATH.'views/' . $request->title . '.phtml', $array);
    } else {
        // 404
        $config = include(SRC_PATH.'core/configuration.php');

        $service->render(APP_PATH.'views/' + '404.phtml', array('home' => $config["paths"]["home"]));
    }
});