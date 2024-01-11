<?php

namespace Itrvb\galimova\Blog\Http\Actions\Likes;

use Itrvb\galimova\Blog\Exceptions\HttpException;
use Itrvb\galimova\Blog\Http\Actions\ActionInterface;
use Itrvb\galimova\Blog\Http\ErrorResponse;
use Itrvb\galimova\Blog\Http\Request;
use Itrvb\galimova\Blog\Http\Response;
use Itrvb\galimova\Blog\Http\SuccessfulResponse;
use Itrvb\galimova\Blog\like;
use Itrvb\galimova\Blog\Repositories\LikesRepository\LikesRepositoryInterface;
use Itrvb\galimova\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use Itrvb\galimova\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Itrvb\galimova\Blog\UUID;
use Psr\Log\LoggerInterface;

class CreateLike implements ActionInterface
{
    public function __construct(
        private LikesRepositoryInterface $likesRepository,
        private UserRepositoryInterface $userRepository,
        private PostsRepositoryInterface $postsRepository,
        private LoggerInterface $logger)
    {
    }

    public function handle(Request $request): Response
    {
        $uuidUser = new UUID($request->jsonBodyField('user_uuid'));
        $user = $this->userRepository->get($uuidUser);

        $uuidPost = new UUID($request->jsonBodyField('post_uuid'));
        $post = $this->postsRepository->get($uuidPost);

        $newLikeUuid = UUID::random();

        try {
            $like = new Like(
                $newLikeUuid,
                $user->uuid,
                $post->uuid,
            );
        } catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        $this->likesRepository->save($like);

        $this->logger->info("Like created: $newLikeUuid");

        return new SuccessfulResponse([
            'uuid' => (string)$newLikeUuid,
        ]);
    }
}