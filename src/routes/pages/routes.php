<?php
/**
 * FastBlog | routes.php
 * Routes file for the public pages requests
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

$klein->respond('/[:title]', function ($request, $response, $service) use($fastblog) {
    if($request->title !== "favicon.ico") {
        try {
            $service->validateParam('title')->isString();

            if (file_exists(APP_PATH . 'views/public/' . $request->title . '.phtml')) {
                $array = array(
                    'latest' => array()
                );

                if (in_array($request->title . '.phtml', $fastblog->config["options"]["article_preview_allowed_pages"])) {
                    $loaderutil = $fastblog->databaseutils;
                    $previews = $loaderutil->getLastXArticles($fastblog->config["options"]["latest_articles_preview_number"]);
                    $array['latest'] = $previews;
                }

                $service->render(APP_PATH . 'views/public/' . $request->title . '.phtml', $array);
            } else {
                $response->code(404);
            }
        } catch (\Klein\Exceptions\ValidationException $exception) {
            $response->code(404);
        }
    }
});

