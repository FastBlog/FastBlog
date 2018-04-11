<?php
/**
 * FastBlog | routes.php
 * Routes file for the public pages requests
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

$klein->respond('/[:title]', function ($request, $response, $service) use($klein, $fastblog) {
    try {
        $service->validateParam('title')->isString();
        if (!in_array($request->title, $fastblog->config["options"]["not_article_name"])) {
            if (file_exists(APP_PATH . 'views/public/' . $request->title . '.phtml')) {
                $array = array(
                    'latest' => array()
                );

                if (in_array($request->title . '.phtml', $fastblog->config["options"]["article_preview_allowed_pages"])) {
                    $loaderutil = $fastblog->databaseutils;
                    $previews = $loaderutil->getLastPublishedArticles($fastblog->config["options"]["latest_articles_preview_number"]);
                    $array['latest'] = $previews;
                }

                $service->render(APP_PATH . 'views/public/' . $request->title . '.phtml', $array);
            } else {
                $service->render(APP_PATH . 'views/public/404.phtml', array('home' => $fastblog->config["domain"]));
            }
        }
    } catch(\Klein\Exceptions\ValidationException $exception) {
        if(!$response->isLocked())
            $service->render(APP_PATH . 'views/public/404.phtml', array('home' => $fastblog->config["domain"]));
    }

});

