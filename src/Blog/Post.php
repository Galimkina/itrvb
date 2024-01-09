<?php
namespace Itrvb\galimova\Blog;

use Itrvb\galimova\Person\Person;

class Post
{
    public function __construct(
        public $id,
        private $author_id,
        private string $title,
        private string $text
    )
    {}
    public function __toString()
    {
        return "<b>ID: </b>" . $this->id . "<b> Автор: </b>" . $this->author_id  . "<b> Заголовок: </b>" . $this->title . "<b> Текст: </b>" . $this->text;
    }
}