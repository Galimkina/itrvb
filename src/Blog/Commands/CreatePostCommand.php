<?php

namespace Itrvb\galimova\Blog\Commands;

use Itrvb\galimova\Blog\Exceptions\CommandException;
use Itrvb\galimova\Blog\Exceptions\UserNotFoundException;
use Itrvb\galimova\Blog\Post;
use Itrvb\galimova\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use Itrvb\galimova\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Itrvb\galimova\Blog\UUID;
use Psr\Log\LoggerInterface;

class CreatePostCommand
{
    public function __construct(
        private PostsRepositoryInterface $postsRepository,
        private UserRepositoryInterface     $userRepository,
        private LoggerInterface $logger)
    {

    }

    public function handle(Arguments $arguments): void
    {
        $this->logger->info("Create post commant started");

        $user_uuid = new UUID($arguments->get('author_uuid'));

        if (!$this->userExisit($user_uuid)) {
            $this->logger->warning("Author not already exists: $user_uuid");
            throw new CommandException(
                "Author not already exists: $user_uuid"
            );

        }
        $this->postsRepository->save(
            new Post(
                UUID::random(),
                new UUID($arguments->get('author_uuid')),
                $arguments->get('title'),
                $arguments->get('text')
            ));
    }
    public function userExisit(UUID $user_uuid): bool
    {
        try {
            $this->userRepository->get($user_uuid);
        } catch (UserNotFoundException) {
            return false;
        }

        return true;
    }
}