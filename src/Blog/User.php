<?php

namespace Itrvb\galimova\Blog;

class User
{
    public function __construct(
        public UUID $uuid,
        public string $username,
        public Name $name
    )
    {}
    public function __toString()
    {
        return "<b>ID: </b>" . $this->uuid . "<b>Логин: </b>" . $this->username . "<b> Автор: </b>" . $this->name;
    }
    public function getUUID() {
        return $this->uuid;
    }
}