<?php
/**
 * Configuration
 * User: HexelDev
 */

namespace HexelDev\Core;

class Configuration {

    /*
     * MySql configuration
     */
    public static $MYSQL_HOST = "";
    public static $MYSQL_PORT = "";
    public static $MYSQL_USER = "";
    public static $MYSQL_PASSWORD = "";
    public static $MYSQL_DB = "";

    /*
     * Domain name
     */
    public static $DOMAIN = "";

    /*
     * Paths to access the home and admin directory
     */
    public static $HOME_PATH = "";
    public static $ADMIN_PATH = "";

    /*
     * Saved articles html files
     */
    public static $ARTICLES_PATH = "../storage";

    /*
     * How many articles preview must be loaded before rendering every front-end page
     */
    public static $LAST_ARTICLES_PREVIEW_NUMBER = "";
}