<?php
/**
 * Configuration
 * User: HexelDev
 */

namespace HexelDev\Core;

return [
    /*
     * MySql configuration values
     */

    "mysql" => [
        "host" => "",
        "port" => "",
        "username" => "",
        "password" => "",
        "db" => ""
    ],

    /*
     * Domain name
     */
    "domain" => [
        "domain" => ""
    ],

    /*
     * Paths configuration values
     */
    "paths" => [
        "home" => "",
        "admin" => "",
        "articles" => "../storage"
    ],

    /*
     * Get options configuration values
     */
    "options" => [
        "article_preview_allowed_pages" => ["index.html"],
        "latest_articles_preview_number" => ""
    ]
];
