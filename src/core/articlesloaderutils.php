<?php
/**
 * Articles loader utility
 * User: HexelDev
 */

namespace HexelDev\Core;

use \ORM;

class ArticlesLoaderUtils {

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
