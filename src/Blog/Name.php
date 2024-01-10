<?php
namespace Itrvb\galimova\Blog;

class Name
{
    public function __construct(
        public string $firstName,
        public string $lastName
    )
    {}
    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}