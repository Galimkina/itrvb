<?php

namespace Itrvb\galimova\Blog\Commands;

use Itrvb\galimova\Blog\Exceptions\CommandException;
use Itrvb\galimova\Blog\Exceptions\UserNotFoundException;
use Itrvb\galimova\Blog\Name;
use Itrvb\galimova\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Itrvb\galimova\Blog\User;
use Itrvb\galimova\Blog\UUID;

class CreateUserCommand
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    )
    {

    }

    public function handle(Arguments $arguments): void
    {
        $username = $arguments->get('username');

        if ($this->userExisit($username)) {
            throw new CommandException(
                "User already exists: $username"
            );
        }

        $this->userRepository->save(
            new User(
                UUID::random(),
                $username,
                new Name($arguments->get('first_name'),$arguments->get('last_name'))
            ));
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