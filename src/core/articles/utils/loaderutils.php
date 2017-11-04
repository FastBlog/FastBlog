<?php
/**
 * FastBlog | loaderutils.php
 * Articles loader utility
 * License: BSD-2-Clause
 */

namespace HexelDev\Core;

use \ORM;

class LoaderUtils {

    public function __construct() {

    }

    /*
     * Get the last $x articles from the latest one
     */
    public function getLastXArticles($x) {
        $previews = ORM::forTable('articles')
            ->orderByDesc('publish_date')
            ->limit($x)->find_many();

        return $previews;
    }

    /*
     * Get the specified article
     */
    public function getArticle($year, $month, $title) {
        $article = ORM::forTable('articles')->where(array(
            'title' => $title,
            'year' => $year,
            'month' => $month
        ))->findOne();

        return $article;
    }
}
