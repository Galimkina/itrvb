<?php

namespace Itrvb\galimova\Blog\Http\Actions\Posts;

use Itrvb\galimova\Blog\Exceptions\HttpException;
use Itrvb\galimova\Blog\Exceptions\PostNotFoundException;
use Itrvb\galimova\Blog\Http\Actions\ActionInterface;
use Itrvb\galimova\Blog\Http\Request;
use Itrvb\galimova\Blog\Http\Response;
use Itrvb\galimova\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use Itrvb\galimova\Blog\UUID;
use Itrvb\galimova\Blog\Http\ErrorResponse;
use Itrvb\galimova\Blog\Http\SuccessfulResponse;
use Psr\Log\LoggerInterface;

class DeletePost implements ActionInterface
{
    public function __construct(
        private PostsRepositoryInterface $postsRepository,
//        private LoggerInterface $logger)
    ) {
    }

    public function handle(Request $request): Response
    {
        try {
            $postUuid = new UUID($request->query('uuid'));

            $this->postsRepository->delete($postUuid);

            return new SuccessfulResponse(['message' => 'Post deleted successfully']);
        } catch (HttpException | PostNotFoundException $e) {
            return new ErrorResponse($e->getMessage());
        }
//        $this->logger->info("User created: $newUserUuid");
    }
}
