<?php

namespace Itrvb\galimova\Blog\Repositories\UserRepository;

use Itrvb\galimova\Blog\User;
use Itrvb\galimova\Blog\UUID;

interface UserRepositoryInterface
{
    public function get(UUID $uuid): User;
    public function save(User $user): void;
    public function getByUsername(string $username): User;
}