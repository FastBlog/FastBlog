<?php
/**
 * FastBlog | edit.php
 * ACP create article class
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

use \ORM;

class ACPNew {
    private $title;
    private $alias;
    private $preview;
    private $datetime;
    private $published;
    private $content;

    public function __construct($title, $alias, $preview, $datetime, $published, $content) {
        $this->title = $title;
        $this->alias = $alias;
        $this->preview = $preview;
        $this->datetime = $datetime;
        $this->published = $published;
        $this->content = $content;
    }

    public function create() {
        $article = ORM::forTable('articles')->set(array(
            "title" => $this->title,
            "alias" => $this->alias,
            "preview" => $this->preview,
            "month" => $this->datetime->m,
            "year" => $this->datetime->y,
            "publishing_date" => $this->datetime,
            "published" => $this->published
        ))->save();
        if($article){
            $tmp = ORM::forTable('articles')->findOne(array(
                "title" => $this->title,
                "alias" => $this->alias,
                "preview" => $this->preview,
                "month" => $this->datetime->m,
                "year" => $this->datetime->y,
                "publishing_date" => $this->datetime,
                "published" => $this->published
            ));

            $filename = STORAGE_PATH.$tmp->get('id').'.fba';
            file_put_contents($filename, $this->content);
            return true;
        }
        return false;
    }
}

