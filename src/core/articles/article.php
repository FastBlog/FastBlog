<?php
/**
 * FastBlog | article.php
 * Article initializer and manager
 * License: BSD-2-Clause
 */

namespace FastBlog\Core;

use \ORM;

class Article {

    private $id;
    private $alias;
    private $preview;

    private $month;
    private $year;
    private $publishing_date;
    private $published;

    private $article_title;
    private $article_body;
    private $article_comments;

    private $existence = false;

    public function __construct($id) {
        $this->id = $id;
        $this->init();
    }

    /**
     * Verify the existence of the article and retrieve the associated db object
     */
    public function init() {
        // Load article from db
        $article = ORM::forTable('articles')->findOne($this->id);

        // If article exists set variables using the db object
        if($article) {
            $this->alias = $article->get('alias');
            $this->preview = $article->get('preview');

            $this->month = $article->get('month');
            $this->year = $article->get('year');
            $this->publishing_date = $article->get('publishing_date');
            $this->published = $article->get('published');

            $this->load();
        }
    }

    /**
     * Verify the existence of a file associated to the article and load the contents
     */
    public function load() {
        $filename = STORAGE_PATH.$this->id.'.fba';
        if (file_exists($filename)) {
            /*
             * Split the file where the blocks terminate "<!--SPLITME-->"
             */
            $text = file_get_contents($filename);
            $array = explode("<!--SPLITME-->",$text);

            // Set the texts for this article
            $this->article_title = $array[0];
            $this->article_body = $array[1];
            $this->article_comments = $array[2];

            // Confirm the existence of the article
            $this->existence = true;
        }
    }

    public function getId() {
        return $this->day;
    }

    public function getMonth() {
        return $this->month;
    }

    public function getYear() {
        return $this->year;
    }

    public function getPublished() {
        return $this->published;
    }

    public function getDate() {
        return $this->publishing_date;
    }

    public function getAlias() {
        return $this->alias;
    }

    public function getPreview() {
        return $this->preview;
    }

    public function getTitle() {
        return $this->article_title;
    }

    public function getBody() {
        return $this->article_body;
    }

    public function getSocialComments() {
        return $this->article_comments;
    }

    public function exist() {
        return $this->existence;
    }
}
