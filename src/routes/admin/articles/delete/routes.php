<?php

/**
 * FastBlog | routes.php
 * Routes file for the acp article deletion
 * License: BSD-3-Clause
 */
namespace FastBlog\Core;

$klein->with('/'.$fastblog->config["paths"]["admin"].'/articles/delete', function () use($klein, $fastblog) {

    if ($fastblog->authentication->isAuthenticated()) {
        $klein->respond('POST', '/[i:id]', function ($request, $response, $service) use ($fastblog) {
            $delete = new ACPDelete($request->id);
            $result = $delete->delete();

            if(!$result) $response->code(406);
        });
    }

});
