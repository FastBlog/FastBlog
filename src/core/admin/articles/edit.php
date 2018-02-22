<?php
/**
 * FastBlog | edit.php
 * ACP edited article class
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

use \ORM;

class ACPEdit {
    private $id;
    private $title;
    private $alias;
    private $preview;
    private $datetime;
    private $published;
    private $content;

    public function __construct($id, $title, $alias, $preview, $datetime, $published, $content) {
        $this->id = $id;
        $this->title = $title;
        $this->alias = $alias;
        $this->preview = $preview;
        $this->datetime = $datetime;
        $this->published = $published;
        $this->content = $content;
    }

    public function editArticle(){
        $article = ORM::forTable('articles')->findOne($this->id);
        if($article) {
            $article->set(array(
                "title" => $this->title,
                "alias" => $this->alias,
                "preview" => $this->preview,
                "month" => $this->datetime->m,
                "year" => $this->datetime->y,
                "publishing_date" => $this->datetime,
                "published" => $this->published
            ))->save();

            $filename = STORAGE_PATH.$this->id.'.fba';
            file_put_contents($filename, $this->content);
            return true;
        }
        return false;
    }
}
