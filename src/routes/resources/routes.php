<?php
/**
 * FastBlog | routes.php
 * Images, JS, CSS headers.
 * License: BSD-2-Clause
 */

$klein->respond('/resources/[*:file].[:type]', function ($request, $response, $service) use($fastblog) {
    $file =  $fastblog->basepath.'app/resources/';
    $tmp_type = '';

    switch( $request->param('type') ) {
        case "css":
            $file = $file.'css/'.$request->param('file').'.css';
            $tmp_type = "text/css";
            break;
        case "js":
            $file = $file.'javascript/'.$request->param('file').'.js';
            $tmp_type = "application/javascript";
            break;
    }

    if(file_exists($file)) {
        $etag = md5_file($file);
        header('Content-Type: '.$tmp_type);
        header('X-Content-Type-Options: nosniff');
        header('Cache-control: public');
        header('Pragma: cache');
        header('Etag: "'.$etag.'"');
        header('Content-Length: ' . filesize($file));
        if($fastblog->config["options"]["long_term_cache"])
            header('Expires: '.gmdate('D, d M Y H:i:s', time() + 60 * 60).' GMT');
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($file)).' GMT');

        $response->body(readfile($file));
    } else {
        $response->code(404)->body($service->render(APP_PATH.'views/public/404.phtml', array('home' => $fastblog->config["domain"])));
    }
});

$klein->respond('/images/[*:image].[:type]', function ($request, $response, $service) use($klein, $fastblog) {
    $file = $fastblog->basepath.'app/resources/images/'.$request->param('image').'.'.$request->param('type');

    if(file_exists($file)) {
        $tmp_type = "";
        switch( $request->param('type') ) {
            case "ico":
                $tmp_type="image/x-icon";
                break;
            case "gif":
                $tmp_type="image/gif";
                break;
            case "png":
                $tmp_type="image/png";
                break;
            case "jpeg":
            case "jpg":
                $tmp_type="image/jpeg";
                break;
            default:
        }

        $etag = md5_file($file);
        header('Content-Type: '.$tmp_type);
        header('X-Content-Type-Options: nosniff');
        header('Cache-control: public');
        header('Pragma: cache');
        header('Etag: "'.$etag.'"');
        if($fastblog->config["options"]["long_term_cache"])
            header('Expires: '.gmdate('D, d M Y H:i:s', time() + 60 * 60).' GMT');
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($file)).' GMT');

        $response->body(file_get_contents($file));
    } else {
        $response->code(404)->body($service->render(APP_PATH.'views/public/404.phtml', array('home' => $fastblog->config["domain"])));
    }
});

$klein->respond('/favicon.ico', function ($request, $response, $service) use($fastblog) {
    $file = $fastblog->basepath.'app/resources/images/favicon.ico';

    if(file_exists($file)) {
        $etag = md5_file($file);
        header('Content-Type: image/x-icon');
        header('X-Content-Type-Options: nosniff');
        header('Cache-control: public');
        header('Pragma: cache');
        header('Etag: "'.$etag.'"');
        header('Content-Length: ' . filesize($file));
        if($fastblog->config["options"]["long_term_cache"])
            header('Expires: '.gmdate('D, d M Y H:i:s', time() + 60 * 60).' GMT');
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($file)).' GMT');

        $response->body(readfile($file));
        $response->lock();
    } else {
        $response->code(404)->body($service->render(APP_PATH.'views/public/404.phtml', array('home' => $fastblog->config["domain"])));
    }
});

