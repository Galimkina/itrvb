<?php

namespace Itrvb\galimova\Blog\Http\Actions\Users;

use Itrvb\galimova\Blog\Exceptions\HttpException;
use Itrvb\galimova\Blog\Exceptions\UserNotFoundException;
use Itrvb\galimova\Blog\Http\Actions\ActionInterface;
use Itrvb\galimova\Blog\Http\ErrorResponse;
use Itrvb\galimova\Blog\Http\Request;
use Itrvb\galimova\Blog\Http\Response;
use Itrvb\galimova\Blog\Http\SuccessfulResponse;
use Itrvb\galimova\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Psr\Log\LoggerInterface;

class FindByUsername implements ActionInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private LoggerInterface $logger)
    {

    }

    public function handle(Request $request): Response
    {
        try {
            $username = $request->query('username');
        } catch (HttpException $error) {
            return new ErrorResponse($error->getMessage());
        }

        try {
            $user = $this->userRepository->getByUsername($username);
        } catch (UserNotFoundException $error) {
            return new ErrorResponse($error->getMessage());
        }

        $this->logger->info("User find: $username");

            return new SuccessfulResponse([
                'username' => $user->username,
                'first_name' => $user->name->firstName,
                'last_name' => $user->name->lastName,
            ]);
    }
}