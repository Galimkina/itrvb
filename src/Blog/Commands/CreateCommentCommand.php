<?php

namespace Itrvb\galimova\Blog\Commands;

use Itrvb\galimova\Blog\Comment;
use Itrvb\galimova\Blog\Exceptions\CommandException;
use Itrvb\galimova\Blog\Exceptions\PostNotFoundException;
use Itrvb\galimova\Blog\Exceptions\UserNotFoundException;
use Itrvb\galimova\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;
use Itrvb\galimova\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use Itrvb\galimova\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Itrvb\galimova\Blog\UUID;
use Psr\Log\LoggerInterface;

class CreateCommentCommand
{
    public function __construct(
        private CommentsRepositoryInterface $commentsRepository,
        private UserRepositoryInterface     $userRepository,
        private PostsRepositoryInterface    $postsRepository,
        private LoggerInterface             $logger)

    {

    }

    public function handle(Arguments $arguments): void
    {
        $this->logger->info("Create comment commant started");

        $user_uuid = new UUID($arguments->get('author_uuid'));

        if (!$this->userExisit($user_uuid)) {
            $this->logger->warning("Author not already exists: $user_uuid");
            throw new CommandException(
                "Author not already exists: $user_uuid"
            );

        }

        $post_uuid = new UUID($arguments->get('post_uuid'));

        if (!$this->postExisit($post_uuid)) {
            $this->logger->warning("Post not already exists: $post_uuid");
            throw new CommandException(
                "Post not already exists: $post_uuid"
            );

        }

        $this->commentsRepository->save(
            new Comment(
                UUID::random(),
                new UUID($arguments->get('author_uuid')),
                new UUID($arguments->get('post_uuid')),
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