<?php

namespace Itrvb\galimova\Blog\Repositories\LikesRepository;

use Itrvb\galimova\Blog\Exceptions\HttpException;
use Itrvb\galimova\Blog\Exceptions\LikeNotFoundException;
use Itrvb\galimova\Blog\Http\ErrorResponse;
use Itrvb\galimova\Blog\LikeComment;
use PDO;
use Itrvb\galimova\Blog\UUID;

class SqliteLikeCommentRepository implements LikesCommentRepositoryInterface
{
    public function __construct(
        private PDO $connection,
    )
    {
    }

    public function save(LikeComment $likeComment): void
    {
        $existingLikes = $this->getByCommentUserUuid($likeComment->comment_uuid, $likeComment->user_uuid);
        if (count($existingLikes) > 0) {
            echo "Вы уже поставили лайк этому комментарию!";
        } else {
            $statement = $this->connection->prepare(
                'INSERT INTO likesComment (uuid, user_uuid, comment_uuid) VALUES (:uuid, :user_uuid, :comment_uuid)'
            );

            $statement->execute([
                ':uuid' => (string)$likeComment->uuid,
                ':user_uuid' => $likeComment->user_uuid,
                ':comment_uuid' => $likeComment->comment_uuid,
            ]);
        }
    }

    public function getByCommentUuid(UUID $comment_uuid): array
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM likesComment WHERE comment_uuid = :comment_uuid'
        );
        $statement->execute([
            ':comment_uuid' => (string)$comment_uuid,
        ]);

        $likesComment = [];

        while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
            $likesComment[] = new LikeComment(
                new UUID($result['uuid']),
                new UUID($result['user_uuid']),
                new UUID($result['comment_uuid'])
            );
        }
        return $likesComment;
    }
    public function getByCommentUserUuid(UUID $comment_uuid, UUID $user_uuid): array
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM likesComment WHERE comment_uuid = :comment_uuid and user_uuid =:user_uuid'
        );
        $statement->execute([
            ':comment_uuid' => (string)$comment_uuid,
            ':user_uuid' => (string)$user_uuid,
        ]);

        $likesComment = [];

        while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
            $likesComment[] = new LikeComment(
                new UUID($result['uuid']),
                new UUID($result['user_uuid']),
                new UUID($result['comment_uuid'])
            );
        }
        return $likesComment;
    }
}
