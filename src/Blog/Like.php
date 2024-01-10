<?php

namespace Itrvb\galimova\Blog;

class like
{
    public function __construct(
        public UUID $uuid,
        public UUID $user_uuid,
        public UUID $post_uuid
    )
    {}
    public function __toString()
    {
        return "<b>ID: </b>" . $this->uuid . "<b> Пользватель: </b>" . $this->user_uuid . "<b> Статья: </b>" . $this->post_uuid;
    }
}