<?php
namespace Itrvb\galimova\Blog\Repositories\LikesRepository;

use Itrvb\galimova\Blog\Exceptions\HttpException;
use Itrvb\galimova\Blog\Exceptions\LikeNotFoundException;
use Itrvb\galimova\Blog\Http\ErrorResponse;
use Itrvb\galimova\Blog\Like;
use PDO;
use Itrvb\galimova\Blog\UUID;

class SqliteLikeRepository implements LikesRepositoryInterface
{
    public function __construct(
        private PDO $connection,
    )
    {
    }

    public function save(Like $like): void
    {
        $existingLikes = $this->getByPostUserUuid($like->post_uuid, $like->user_uuid);
        if (count($existingLikes) > 0) {
            echo "Вы уже поставили лайк этой статье!";
        } else {
            $statement = $this->connection->prepare(
                'INSERT INTO likes (uuid, user_uuid, post_uuid) VALUES (:uuid, :user_uuid, :post_uuid)'
            );

            $statement->execute([
                ':uuid' => (string)$like->uuid,
                ':user_uuid' => $like->user_uuid,
                ':post_uuid' => $like->post_uuid,
            ]);
        }
    }

    public function getByPostUuid(UUID $post_uuid): array
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM likes WHERE post_uuid = :post_uuid'
        );
        $statement->execute([
            ':post_uuid' => (string)$post_uuid,
        ]);

        $likes = [];

        while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
            $likes[] = new Like(
                new UUID($result['uuid']),
                new UUID($result['user_uuid']),
                new UUID($result['post_uuid'])
            );
        }
        return $likes;
    }
    public function getByPostUserUuid(UUID $post_uuid, UUID $user_uuid): array
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM likes WHERE post_uuid = :post_uuid and user_uuid=:user_uuid'
        );
        $statement->execute([
            ':post_uuid' => (string)$post_uuid,
            ':user_uuid' => (string)$user_uuid,
        ]);

        $likes = [];

        while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
            $likes[] = new Like(
                new UUID($result['uuid']),
                new UUID($result['user_uuid']),
                new UUID($result['post_uuid'])
            );
        }
        return $likes;
    }
}
