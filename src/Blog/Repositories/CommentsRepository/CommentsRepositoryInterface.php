<?php
namespace Itrvb\galimova\Blog\Repositories\CommentsRepository;

use Itrvb\galimova\Blog\Comment;
use Itrvb\galimova\Blog\UUID;

interface CommentsRepositoryInterface
{
    public function get(UUID $uuid): Comment;
    public function save(Comment $comment): void;
}