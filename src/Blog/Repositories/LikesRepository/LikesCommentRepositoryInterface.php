<?php

namespace Itrvb\galimova\Blog\Repositories\LikesRepository;

use Itrvb\galimova\Blog\LikeComment;
use Itrvb\galimova\Blog\UUID;

interface LikesCommentRepositoryInterface
{
    public function getByCommentUuid(UUID $comment_uuid): array;
    public function getByCommentUserUuid(UUID $comment_uuid, UUID $user_uuid): array;
    public function save(LikeComment $likeComment): void;
}