<?php

namespace Itrvb\galimova\Blog\Repositories\PostsRepository;

use Itrvb\galimova\Blog\Exceptions\PostNotFoundException;
use Itrvb\galimova\Blog\Post;
use PDO;
use Itrvb\galimova\Blog\UUID;

class SqlitePostRepository implements PostsRepositoryInterface
{
    public function __construct(
        private PDO $connection,
    )
    {}

    public function save(Post $post): void
    {
        $statement = $this->connection->prepare(
            'INSERT INTO posts (uuid, author_uuid, title, text) VALUES (:uuid, :author_uuid, :title, :text)'
        );

        $statement->execute([
            ':uuid' => (string)$post->uuid,
            ':author_uuid' => $post->author_uuid,
            ':title' => $post->title,
            ':text' => $post->text,
        ]);
    }

    public function get(UUID $uuid): Post
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM posts WHERE uuid = :uuid'
        );
        $statement->execute([
            ':uuid' => (string)$uuid,
        ]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result === false) {
            throw new PostNotFoundException(
                "Cannot get post: $uuid"
            );
        }

        return new Post(
            new UUID($result['uuid']),
            $result['author_uuid'],
            $result['title'],
            $result['text']
        );
    }
}