<?php
/**
 * FastBlog | routes.php
 * Routes file for the public blog requests
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

use \ORM;

$klein->respond('/article/[i:year]/[i:month]/[*:alias]', function ($request, $response, $service) use($fastblog){
    try {
        $service->validateParam('year')->isInt();
        $service->validateParam('month')->isInt();
        $service->validateParam('alias')->isString();
        $a = ORM::forTable('articles')->where(array(
            'year' => $request->year,
            'month' => $request->month,
            'alias' => $request->alias
        ))->findOne();
        if($a) {
            $article = new Article($a->id());
            if($article->exist()) {
                $service->render(APP_PATH . 'views/template/article/article.phtml', array(
                    'article_url' => 'http://'.$fastblog->config["domain"] . '/article/' . $request->year . '/' . $request->month . '/' . $request->alias,
                    'month' => $article->getMonth(),
                    'year' => $article->getYear(),
                    'date' => $article->getDate(),
                    'title' => $article->getTitle(),
                    'description' => $article->getDescription(),
                    'body' => $article->getBody(),
                    'social' => $article->getSocialComments(),
                    'image' => $article->getPreview()
                ));
            } else {
                $response->code(404)->body($service->render(APP_PATH.'views/public/404.phtml', array('home' => $fastblog->config["domain"])));
            }
        } else {
            $response->code(404)->body($service->render(APP_PATH.'views/public/404.phtml', array('home' => $fastblog->config["domain"])));
        }
    } catch (\Klein\Exceptions\ValidationException $e) {
        $response->code(404)->body($service->render(APP_PATH.'views/public/404.phtml', array('home' => $fastblog->config["domain"])));
    }
});
