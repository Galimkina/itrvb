<?php

namespace Itrvb\galimova\Blog;

class Comment
{
    public function __construct(
        public UUID $uuid,
        public UUID $author_uuid,
        public UUID $post_uuid,
        public string $text
    )
    {}
    public function __toString()
    {
        return"<b>ID: </b>" . $this->uuid . "<b> Автор: </b>" . $this->author_uuid . "<b> Статья: </b>" . $this->post_uuid . "<b> Текст: </b>" . $this->text;
    }
}