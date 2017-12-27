<?php
/**
 * FastBlog | articleloader.php
 * //File description
 * License: BSD-2-Clause
 */

namespace FastBlog\Core;


class ArticleFactory {
    public function __construct() {

    }

    /*
     * Initialize and return a new Article object
     */
    public function getArticle($year, $month, $alias) {
        return new Article($year, $month, $alias);
    }
}
