<?php
namespace Itrvb\galimova\Blog\Repositories\PostsRepository;

use Itrvb\galimova\Blog\Post;
use Itrvb\galimova\Blog\UUID;

interface PostsRepositoryInterface
{
    public function get(UUID $uuid): Post;
    public function save(Post $post): void;
}