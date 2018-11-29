<?php
/**
 * FastBlog | loader.php
 * Includes the required php core files
 * License: BSD-2-Clause
 */

/*
 * Include composer
 */
require_once(BASE_PATH.'vendor/autoload.php');

require_once(SRC_PATH.'core/configuration.php');

$coredir = SRC_PATH.'core/';
$coretree = scandir($coredir);

foreach($coretree as $routes_entry) {
    if (!in_array($routes_entry, array(".",".."))) {
        if (is_dir($coredir . $routes_entry)) {
            if (file_exists($coredir . $routes_entry . '/loadmodule.php')) {
                include $coredir . $routes_entry . '/loadmodule.php';
            }
        }
    }
}

require_once(SRC_PATH.'core/admin/authentication.php');

/*
require_once(BASE_PATH.'vendor/autoload.php');

require_once(SRC_PATH.'core/configuration.php');

require_once(SRC_PATH.'core/articles/article.php');
require_once(SRC_PATH.'core/articles/utils/loaderutils.php');

require_once(SRC_PATH.'core/admin/authentication.php');
require_once(SRC_PATH.'core/admin/articles/new.php');
require_once(SRC_PATH.'core/admin/articles/edit.php');
require_once(SRC_PATH.'core/admin/articles/delete.php');
*/