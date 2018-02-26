<?php
/**
 * FastBlog | routes.php
 * Routes file for the public blog requests
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

$klein->respond('/article/[i:year]/[i:month]/[*:title]', function ($request, $response, $service) use($fastblog){
    try {
        $service->validateParam('year')->isInt();
        $service->validateParam('month')->isInt();
        $service->validateParam('title')->isString();

        $article = new Article($request->year, $request->month, $request->title);
        if($article->exist()) {
            $service->render('article.phtml', array(
                'p_day' => $article->getDay(),
                'p_month' => $article->getMonth(),
                'p_year' => $article->getYear(),
                'title' => $article->getTitle(),
                'body' => $article->getBody(),
                'social' => $article->getSocial()
            ));
        } else {
            $response->code(404);
        }
    } catch (\Klein\Exceptions\ValidationException $e) {
        $response->code(404);
    }
});
