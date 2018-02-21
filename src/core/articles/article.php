<?php
/**
 * FastBlog | article.php
 * Article initializer and manager
 * License: BSD-2-Clause
 */

namespace FastBlog\Core;

class Article {

    private $day;
    private $month;
    private $year;
    private $title;

    private $existence = false;
    private $id;
    private $published;

    private $alias;

    private $article_title;
    private $article_body;
    private $article_fb;

    public function __construct($year, $month, $alias) {
        $this->year = $year;
        $this->month = $month;
        $this->alias = $alias;
        $this->init();
    }

    /**
     * Verify the existence of the article and retrieve the associated db object
     */
    public function init() {
        // Load article from db
        $loader = new DatabaseUtils();
        $article = $loader->getArticle($this->year, $this->month, $this->alias);

        // If article exists set variables using the db object
        if($article) {
            $this->id = $article->get('id');
            $this->day = $article->get('date');
            $this->article_title = $article->get('title');
            $this->published = $article->get('published');

            $this->load();
        }
    }

    /**
     * Verify the existence of a file associated to the article and load the contents
     */
    public function load() {
        $filename = STORAGE_PATH.$this->id.'.sb';
        if (file_exists($filename)) {

            /*
             * Split the file where the blocks terminate "<!--SPLITME-->"
             */
            $text = file_get_contents($filename, true, null);
            $array = explode("<!--SPLITME-->",$text);

            // Set the texts for this article
            $this->article_body = $array[0];
            $this->article_fb = $array[1];

            // Confirm the existence of the article
            $this->existence = true;
        }
    }

    public function getDay() {
        return $this->day;
    }

    public function getMonth() {
        return $this->month;
    }

    public function getYear() {
        return $this->year;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getBody() {
        return $this->article_body;
    }

    public function getSocial() {
        return $this->article_fb;
    }

    public function exist() {
        return $this->existence;
    }
}
