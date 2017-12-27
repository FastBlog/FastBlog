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

/*
 * Include configuration
 */
require_once(SRC_PATH.'core/configuration.php');

/*
 * Include articles and related utils
 */
require_once(SRC_PATH.'core/articles/article.php');
require_once(SRC_PATH.'core/articles/utils/loaderutils.php');