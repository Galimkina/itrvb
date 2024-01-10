<?php

namespace Itrvb\galimova\Blog\Commands;

use Itrvb\galimova\Blog\Post;
use Itrvb\galimova\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use Itrvb\galimova\Blog\UUID;

class CreatePostCommand
{
    public function __construct(
        private PostsRepositoryInterface $postsRepository,
    )
    {

    }

    public function handle(Arguments $arguments): void
    {
        $this->postsRepository->save(
            new Post(
                UUID::random(),
                new UUID($arguments->get('author_uuid')),
                $arguments->get('title'),
                $arguments->get('text')
            ));
    }
}