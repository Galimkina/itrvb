<?php

namespace Itrvb\galimova\Blog\Commands;

use Itrvb\galimova\Blog\Comment;
use Itrvb\galimova\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;
use Itrvb\galimova\Blog\UUID;

class CreateCommentCommand
{
    public function __construct(
        private CommentsRepositoryInterface $commentsRepository,
    )
    {

    }

    public function handle(Arguments $arguments): void
    {
        $this->commentsRepository->save(
            new Comment(
                UUID::random(),
                new UUID($arguments->get('author_uuid')),
                new UUID($arguments->get('post_uuid')),
                $arguments->get('text')
            ));
    }
}