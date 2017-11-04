<?php
/**
 * FastBlog | configuration.php
 * Configuration
 * License: BSD-2-Clause
 */

namespace FastBlog\Core;

return array(

    /*
     * MySql configuration values
     */
    "mysql" => array(
        "host" => "",
        "port" => "",
        "username" => "",
        "password" => "",
        "db" => ""
    ),

    /*
     * Domain name
     */
    "domain" => array(
        "domain" => ""
    ),

    /*
     * Paths configuration values
     */
    "paths" => array(
        "admin" => "",
        "generic" => ""
    ),

    /*
     * Get options configuration values
     */
    "options" => array(
        "article_preview_allowed_pages" => array("index.html"),
        "latest_articles_preview_number" => ""
    )
);
