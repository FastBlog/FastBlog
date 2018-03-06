<?php
/**
 * FastBlog | edit.php
 * ACP edited article class
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

use \ORM, \DateTime;

class ACPEditArticle {
    private $id;
    private $alias;
    private $preview;
    private $datetime;
    private $published;
    private $content;

    public function __construct($id, $alias, $preview, $datetime, $published, $content) {
        $this->id = $id;
        $this->alias = $alias;
        $this->preview = $preview;
        $this->datetime = $datetime;
        $this->published = $published;
        $this->content = $content;
    }

    public function edit(){
        $article = ORM::forTable('articles')->findOne($this->id);
        if($article) {
            $date = DateTime::createFromFormat("Y-m-d", $this->datetime);
            $m = intval($date->format("m"));
            $y = intval($date->format("Y"));
            $article->set(array(
                "alias" => $this->alias,
                "preview" => $this->preview,
                "month" => $m,
                "year" => $y,
                "publishing_date" => $date->format("Y-m-d"),
                "published" => $this->published
            ))->save();

            $filename = STORAGE_PATH . $article->id() . '.fba';
            file_put_contents($filename, $this->content);
            return true;
        }
        return false;
    }
}
