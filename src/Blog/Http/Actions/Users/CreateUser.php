<?php

namespace Itrvb\galimova\Blog\Http\Actions\Users;

use Itrvb\galimova\Blog\Exceptions\HttpException;
use Itrvb\galimova\Blog\Http\Actions\ActionInterface;
use Itrvb\galimova\Blog\Http\ErrorResponse;
use Itrvb\galimova\Blog\Http\Request;
use Itrvb\galimova\Blog\Http\Response;
use Itrvb\galimova\Blog\Http\SuccessfulResponse;
use Itrvb\galimova\Blog\Name;
use Itrvb\galimova\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Itrvb\galimova\Blog\User;
use Itrvb\galimova\Blog\UUID;
use Psr\Log\LoggerInterface;

class CreateUser implements ActionInterface
{
    public function __construct(
        private UserRepositoryInterface $usersRepository,
        private LoggerInterface $logger)
    {
    }

    public function handle(Request $request): Response
    {
        $newUserUuid = UUID::random();

        try {
            $user = new User(
                $newUserUuid,
                $request->jsonBodyField('username'),
                new Name(
                    $request->jsonBodyField('first_name'),
                    $request->jsonBodyField('last_name'),
                ),
            );
        } catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        $this->usersRepository->save($user);

        $this->logger->info("User created: $newUserUuid");

        return new SuccessfulResponse([
            'uuid' => (string)$newUserUuid
        ]);
    }
}