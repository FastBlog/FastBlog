<?php
/**
 * FastBlog | routes.php
 * Routes file for the acp articles edit
 * License: BSD-3-Clause
 */
namespace FastBlog\Core;

$klein->with('/'.$fastblog->config["paths"]["admin"].'/articles/edit/[i:id]', function () use($klein, $fastblog) {

    if ($fastblog->authentication->isAuthenticated()) {
        $klein->respond('GET', '', function ($request, $response, $service) use ($fastblog) {
            $article = new Article($request->id);
            if ($article) {
                $service->render(APP_PATH . 'views/admin/acp/articles/edit/index.phtml', array(
                    "article" => $article
                ));
            } else {
                $service->redirect($fastblog->config["paths"]["admin"] . '/articles', 302);
            }
        });

        $klein->respond('POST','/save', function ($request, $response, $service) use ($fastblog) {
                $edit = new ACPEditArticle($request->id ,$request->alias, $request->preview, $request->datetime, $request->published, $request->content);
                $edit->edit();
        });
    }

});
