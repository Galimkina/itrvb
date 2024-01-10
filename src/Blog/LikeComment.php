<?php

namespace Itrvb\galimova\Blog;

class LikeComment
{
    public function __construct(
        public UUID $uuid,
        public UUID $user_uuid,
        public UUID $comment_uuid
    )
    {}
    public function __toString()
    {
        return "<b>ID: </b>" . $this->uuid . "<b> Пользватель: </b>" . $this->user_uuid . "<b> Комментарий: </b>" . $this->comment_uuid;
    }
}