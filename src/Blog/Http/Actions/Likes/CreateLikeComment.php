<?php

namespace Itrvb\galimova\Blog\Http\Actions\Likes;

use Itrvb\galimova\Blog\Exceptions\HttpException;
use Itrvb\galimova\Blog\Http\Actions\ActionInterface;
use Itrvb\galimova\Blog\Http\ErrorResponse;
use Itrvb\galimova\Blog\Http\Request;
use Itrvb\galimova\Blog\Http\Response;
use Itrvb\galimova\Blog\Http\SuccessfulResponse;
use Itrvb\galimova\Blog\LikeComment;
use Itrvb\galimova\Blog\Repositories\LikesRepository\LikesCommentRepositoryInterface;
use Itrvb\galimova\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;
use Itrvb\galimova\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Itrvb\galimova\Blog\UUID;

class CreateLikeComment implements ActionInterface
{
    public function __construct(
        private LikesCommentRepositoryInterface $likesCommentRepository,
        private UserRepositoryInterface $userRepository,
        private CommentsRepositoryInterface $commentsRepository)
    {
    }

    public function handle(Request $request): Response
    {
        $uuidUser = new UUID($request->jsonBodyField('user_uuid'));
        $user = $this->userRepository->get($uuidUser);

        $uuidComment = new UUID($request->jsonBodyField('comment_uuid'));
        $comment = $this->commentsRepository->get($uuidComment);

        $newLikeCommentUuid = UUID::random();

        try {
            $likeComment = new LikeComment(
                $newLikeCommentUuid,
                $user->uuid,
                $comment->uuid,
            );
        } catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        $this->likesCommentRepository->save($likeComment);

        return new SuccessfulResponse([
            'uuid' => (string)$newLikeCommentUuid,
        ]);
    }
}