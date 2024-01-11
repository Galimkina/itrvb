<?php

namespace Itrvb\galimova\Blog\Http\Actions\Comments;

use Itrvb\galimova\Blog\Comment;
use Itrvb\galimova\Blog\Exceptions\HttpException;
use Itrvb\galimova\Blog\Http\Actions\ActionInterface;
use Itrvb\galimova\Blog\Http\ErrorResponse;
use Itrvb\galimova\Blog\Http\Request;
use Itrvb\galimova\Blog\Http\Response;
use Itrvb\galimova\Blog\Http\SuccessfulResponse;
use Itrvb\galimova\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;
use Itrvb\galimova\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use Itrvb\galimova\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Itrvb\galimova\Blog\UUID;
use Psr\Log\LoggerInterface;

class CreateComment implements ActionInterface
{
    public function __construct(
        private CommentsRepositoryInterface $commentsRepository,
        private UserRepositoryInterface $userRepository,
        private PostsRepositoryInterface $postsRepository,
        private LoggerInterface $logger)
    {
    }

    public function handle(Request $request): Response
    {
        $uuidUser = new UUID($request->jsonBodyField('author_uuid'));
        $user = $this->userRepository->get($uuidUser);

        $uuidPost = new UUID($request->jsonBodyField('post_uuid'));
        $post = $this->postsRepository->get($uuidPost);

        $newCommentUuid = UUID::random();

        try {
            $comment = new Comment(
                $newCommentUuid,
                $user->uuid,
                $post->uuid,
                $request->jsonBodyField('text')
            );
        } catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        $this->commentsRepository->save($comment);

        $this->logger->info("User created: $newCommentUuid");

        return new SuccessfulResponse([
            'uuid' => (string)$newCommentUuid,
        ]);
    }
}