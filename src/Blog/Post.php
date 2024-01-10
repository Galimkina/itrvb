<?php
namespace Itrvb\galimova\Blog;

class Post
{
    public function __construct(
        public UUID $uuid,
        public UUID $author_uuid,
        public string $title,
        public string $text
    )
    {}
    public function __toString()
    {
        return "<b>ID: </b>" . $this->uuid . "<b> Автор: </b>" . $this->author_uuid  . "<b> Заголовок: </b>" . $this->title . "<b> Текст: </b>" . $this->text;
    }
}