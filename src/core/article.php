<?php
/**
 * Article initializer and manager
 * User: HexelDev
 */

namespace HexelDev\Core;


class Article {

    private $day;
    private $month;
    private $year;
    private $title;


    private $existence = false;
    private $id;
    private $published;

    private $article_title;
    private $article_body;
    private $article_fb;

    public function __construct($year, $month, $title, $backend) {
        $this->year = $year;
        $this->month = $month;
        $this->db_title = $title;
        $this->init();
    }

    /*
     * Verify the existence of the article and retrieve the associated file
     */
    public function init() {
        $article = (new ArticlesLoaderUtils())->getArticle($this->year, $this->month, $this->db_title);
        if($article->count() > 0) {
            $this->id = $article->get('id');
            $this->day = $article->get('date');
            $this->published = $article->get('published');

            $this->load();
        }
    }

    public function load() {
        $filename = Configuration::$ARTICLES_PATH.'/'.$this->id.'.sb';
        if (file_exists($filename)) {

            // Get blocks single length.
            // Seems the best way to face this problem, a db interaction will separate the information.
            $file = fopen($filename, "rb");
            $title_length = fread($file, sizeof(PHP_INT_SIZE));
            $body_length = fread($file, sizeof(PHP_INT_SIZE));
            $fb_integration_length = $title = fread($file, sizeof(PHP_INT_SIZE));
            fclose($file);

            // Split the file where the blocks terminate
            // file_get_contents() should be the best option for this operation.
            // an alternative should be an fread() using the $file pointer just after the lengths block
            $text = file_get_contents($filename, true, null ,$title_length + $body_length + $fb_integration_length);
            $text = wordwrap($text, $title_length + $body_length, "\<splitme\>");
            $text = wordwrap($text, $title_length, "\<splitme\>");
            $array = explode("\<splitme\>",$text);

            // Set the texts for this article
            $this->article_title = $array[0];
            $this->article_body = $array[1];
            $this->article_fb = $array[2];
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
