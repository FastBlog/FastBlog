<?php
/**
 * FastBlog | routes.php
 * //File description
 * License: BSD-2-Clause
 */

$klein->respond('/resources/[*:file].[:type]', function ($request, $response, $service) use($fastblog) {
    $file =  $fastblog->basepath.'app/resources/';

    if($request->param('type') == 'css') {
        $file = $file.'css/'.$request->param('file').'.'.$request->param('type');
        header('Content-Type: text/css');
    } else if($request->param('type') == 'js') {
        $file = $file.'javascript/'.$request->param('file').'.'.$request->param('type');
        header('Content-Type: application/javascript');
    }

    if(file_exists($file)) {
        $etag = md5_file($file);

        header('X-Content-Type-Options: nosniff');
        header('Etag: "'.$etag.'"');
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($file)).' GMT');

        $response->file($file);
    } else {
        $response->code(404)->body("Resource not found!");
    }
});

$klein->respond('/images/[*:image]', function ($request, $response, $service) use($fastblog) {
    $file = $fastblog->basepath.'app/resources/images/'.$request->param('image');

    if(file_exists($file)) {
        $response->file($file);
    } else {
        $response->code(404)->body("Image not found!");
    }
});