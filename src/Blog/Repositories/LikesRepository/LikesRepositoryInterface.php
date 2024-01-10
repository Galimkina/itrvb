<?php
namespace Itrvb\galimova\Blog\Repositories\LikesRepository;

use Itrvb\galimova\Blog\Like;
use Itrvb\galimova\Blog\UUID;

interface LikesRepositoryInterface
{
    public function getByPostUuid(UUID $post_uuid): array;
    public function getByPostUserUuid(UUID $post_uuid, UUID $user_uuid): array;
    public function save(Like $like): void;
}