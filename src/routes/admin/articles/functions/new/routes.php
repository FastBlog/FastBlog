<?php
/**
* FastBlog | routes.php
* Routes file for the acp article creation
* License: BSD-3-Clause
*/
namespace FastBlog\Core;

$klein->with('/'.$fastblog->config["paths"]["admin"].'/articles/new', function () use($klein, $fastblog) {
    $klein->respond('GET', '/', function ($request, $response, $service) use ($fastblog) {
        $service->render(APP_PATH . 'views/admin/articles/new/index.phtml');
    });

    $klein->respond('POST', '/save', function ($request, $response, $service) use ($fastblog) {
        if($fastblog->authentication->isAuthenticated()) {
            $new = new ACPNewArticle($request->alias, $request->preview, $request->datetime, $request->published, $request->content);
            $new->create();
        }
    });
});