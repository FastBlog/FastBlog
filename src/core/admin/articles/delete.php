<?php
/**
 * FastBlog | delete.php
 * ACP delete article class
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

use \ORM;

class ACPDelete {
    private $id;

    public function __construct($id) {
        $this->id = $id;
    }

    public function delete() {
        $article = ORM::forTable('articles')->findOne($this->id);
        if($article) {
            $filename = STORAGE_PATH.$this->id.'.fba';
            return $article->delete() && unlink($filename);
        } else {
            return false;
        }
    }
}
