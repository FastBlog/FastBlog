<?php
/**
 * FastBlog | edit.php
 * ACP create article class
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

use \ORM, \DateTime;

class ACPNewArticle {
    private $alias;
    private $preview;
    private $datetime;
    private $published;
    private $content;

    public function __construct($alias, $preview, $datetime, $published, $content) {
        $this->alias = $alias;
        $this->preview = $preview;
        $this->datetime = $datetime;
        $this->published = $published;
        $this->content = $content;
    }

    public function create() {
        $date = DateTime::createFromFormat("Y-m-d", $this->datetime);
        $m = intval($date->format("m"));
        $y = intval($date->format("Y"));
        $tmp = ORM::forTable('articles')->where(array(
            "alias" => $this->alias,
            "month" => $m,
            "year" => $y
        ))->findOne();
        if (!$tmp) {
            $article = ORM::forTable('articles')->create();
            $article->set(array(
                "alias" => $this->alias,
                "preview" => $this->preview,
                "month" => $m,
                "year" => $y,
                "publishing_date" => $date->format("Y-m-d"),
                "published" => $this->published
            ))->save();
            if ($article) {
                $filename = STORAGE_PATH . $article->id() . '.fba';
                file_put_contents($filename, $this->content);
                return true;
            }
        }
        return false;
    }
}
