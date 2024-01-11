<?php

namespace Itrvb\galimova\Blog\Commands;

use Itrvb\galimova\Blog\Exceptions\CommandException;
use Itrvb\galimova\Blog\Exceptions\CommentNotFoundException;
use Itrvb\galimova\Blog\Exceptions\UserNotFoundException;
use Itrvb\galimova\Blog\LikeComment;
use Itrvb\galimova\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;
use Itrvb\galimova\Blog\Repositories\LikesRepository\LikesCommentRepositoryInterface;
use Itrvb\galimova\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Itrvb\galimova\Blog\UUID;
use Psr\Log\LoggerInterface;

class CreateLikeCommentCommand
{
    public function __construct(
        private LikesCommentRepositoryInterface $likesCommentRepository,
        private UserRepositoryInterface $userRepository,
        private CommentsRepositoryInterface $commentsRepository,
        private LoggerInterface $logger)

    {

    }

    public function handle(Arguments $arguments): void
    {
        $this->logger->info("Create like comment commant started");

        $user_uuid = new UUID($arguments->get('user_uuid'));

        if (!$this->userExisit($user_uuid)) {
            $this->logger->warning("Author not already exists: $user_uuid");
            throw new CommandException(
                "Author not already exists: $user_uuid"
            );

        }

        $comment_uuid = new UUID($arguments->get('comment_uuid'));

        if (!$this->commentExisit($comment_uuid)) {
            $this->logger->warning("Comment not already exists: $comment_uuid");
            throw new CommandException(
                "Comment not already exists: $comment_uuid"
            );
        }

        $this->likesCommentRepository->save(
            new LikeComment(
                UUID::random(),
                new UUID($arguments->get('user_uuid')),
                new UUID($arguments->get('comment_uuid'))
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

    public function commentExisit(UUID $comment_uuid): bool
    {
        try {
            $this->commentsRepository->get($comment_uuid);
        } catch (CommentNotFoundException) {
            return false;
        }

        return true;
    }
}