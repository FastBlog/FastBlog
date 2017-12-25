<?php
/**
 * FastBlog | routes.php
 * Routes file for the public pages requests
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

$klein->respond('/[*:title]', function ($request, $response, $service) use($fastblog) {
    $service->validateParam('title')->isString();
    $config = $fastblog->config;
    if(file_exists(APP_PATH.'views/' . $request->title . '.phtml')) {
        $array = array(

        );

        if(in_array($request->title . '.phtml', $config["options"]["article_preview_allowed_pages"])) {
            $loaderutil = new DatabaseUtils();
            $previews = $loaderutil->getLastXArticles($config["options"]["latest_articles_preview_number"]);
            $array['latests'] = $previews;
        }

        $service->render(APP_PATH.'views/' . $request->title . '.phtml', $array);
    } else {
        // 404
        $service->render(APP_PATH.'views/404.phtml', array('home' => $config["domain"]));
    }
});

