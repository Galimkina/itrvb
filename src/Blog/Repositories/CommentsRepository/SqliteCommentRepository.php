<?php
namespace Itrvb\galimova\Blog\Repositories\CommentsRepository;

use Itrvb\galimova\Blog\Comment;
use Itrvb\galimova\Blog\Exceptions\CommentNotFoundException;
use PDO;
use Itrvb\galimova\Blog\UUID;

class SqliteCommentRepository implements CommentsRepositoryInterface
{
    public function __construct(
        private PDO $connection,
    )
    {}

    public function save(Comment $comment): void
    {
        $statement = $this->connection->prepare(
            'INSERT INTO comments (uuid, author_uuid, post_uuid, textx) VALUES (:uuid, :author_uuid, :post_uuid, :text)'
        );

        $statement->execute([
            ':uuid' => (string)$comment->uuid,
            ':author_uuid' => $comment->author_uuid,
            ':post_uuid' => $comment->post_uuid,
            ':text' => $comment->text,
        ]);
    }

    public function get(UUID $uuid): Comment
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM comments WHERE uuid = :uuid'
        );
        $statement->execute([
            ':uuid' => (string)$uuid,
        ]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result === false) {
            throw new CommentNotFoundException(
                "Cannot get comments: $uuid"
            );
        }

        return new Comment(
            new UUID($result['uuid']),
            $result['author_uuid'],
            $result['post_uuid'],
            $result['text']
        );
    }
}