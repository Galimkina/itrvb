<?php

namespace Itrvb\galimova\Blog\Commands;

use Itrvb\galimova\Blog\Exceptions\CommandException;
use Itrvb\galimova\Blog\Exceptions\PostNotFoundException;
use Itrvb\galimova\Blog\Exceptions\UserNotFoundException;
use Itrvb\galimova\Blog\like;
use Itrvb\galimova\Blog\Repositories\LikesRepository\LikesRepositoryInterface;
use Itrvb\galimova\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use Itrvb\galimova\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Itrvb\galimova\Blog\UUID;
use Psr\Log\LoggerInterface;

class CreateLikeCommand
{
    public function __construct(
        private LikesRepositoryInterface $likesRepository,
        private UserRepositoryInterface     $userRepository,
        private PostsRepositoryInterface    $postsRepository,
        private LoggerInterface             $logger)

    {

    }

    public function handle(Arguments $arguments): void
    {
        $this->logger->info("Create like commant started");

        $user_uuid = new UUID($arguments->get('user_uuid'));

        if (!$this->userExisit($user_uuid)) {
            $this->logger->warning("User not already exists: $user_uuid");
            throw new CommandException(
                "User not already exists: $user_uuid"
            );

        }

        $post_uuid = new UUID($arguments->get('post_uuid'));

        if (!$this->postExisit($post_uuid)) {
            $this->logger->warning("Post not already exists: $post_uuid");
            throw new CommandException(
                "Post not already exists: $post_uuid"
            );

        }

        $this->likesRepository->save(
            new Like(
                UUID::random(),
                new UUID($arguments->get('user_uuid')),
                new UUID($arguments->get('post_uuid'))
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

    public function postExisit(UUID $post_uuid): bool
    {
        try {
            $this->postsRepository->get($post_uuid);
        } catch (PostNotFoundException) {
            return false;
        }

        return true;
    }
}