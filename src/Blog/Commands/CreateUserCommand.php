<?php

namespace Itrvb\galimova\Blog\Commands;

use Itrvb\galimova\Blog\Exceptions\CommandException;
use Itrvb\galimova\Blog\Exceptions\UserNotFoundException;
use Itrvb\galimova\Blog\Name;
use Itrvb\galimova\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Itrvb\galimova\Blog\User;
use Itrvb\galimova\Blog\UUID;
use Psr\Log\LoggerInterface;

class CreateUserCommand
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private LoggerInterface $logger,
    )
    {

    }

    public function handle(Arguments $arguments): void
    {
        $this->logger->info("Create user commant started");

        $username = $arguments->get('username');

        if ($this->userExisit($username)) {
            $this->logger->warning("User already exists: $username");
            throw new CommandException(
                "User already exists: $username"
            );

        }

//        $this->userRepository->save(
            $user = User::createFrom(
                $username,
                new Name($arguments->get('first_name'),$arguments->get('last_name'))
            );
        $this->userRepository->save($user);

        $this->logger->info("User created: " . $user->uuid);
    }

    public function userExisit(string $username): bool
    {
        try {
            $this->userRepository->getByUsername($username);
        } catch (UserNotFoundException) {
            return false;
        }

        return true;
    }
}