<?php

namespace Itrvb\galimova\Blog;

use Itrvb\galimova\Person\Person;
use Itrvb\galimova\Blog\Post;

class Comment
{
    public function __construct(
        public $id,
        private $author_id,
        private $post_id,
        private string $text
    )
    {}
    public function __toString()
    {
        return"<b>ID: </b>" . $this->id . "<b> Автор: </b>" . $this->author_id . "<b> Статья: </b>" . $this->post_id . "<b> Текст: </b>" . $this->text;
    }
}