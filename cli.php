<?php
use Itrvb\galimova\Blog\Commands\Arguments;
use Itrvb\galimova\Blog\Commands\CreateCommentCommand;
use Itrvb\galimova\Blog\Commands\CreatePostCommand;
use Itrvb\galimova\Blog\Commands\CreateUserCommand;
use Itrvb\galimova\Blog\Exceptions\CommandException;
use Itrvb\galimova\Blog\Repositories\CommentsRepository\SqliteCommentRepository;
use Itrvb\galimova\Blog\Repositories\PostsRepository\SqlitePostRepository;
use Itrvb\galimova\Blog\Repositories\UserRepository\SqliteUsersRepository;

require_once __DIR__ . '/vendor/autoload.php';

$connection = new PDO('sqlite:' . __DIR__ . '/blog.sqlite');

//$userRepository = new SqliteUsersRepository($connection);
//$command = new CreateUserCommand($userRepository);
//try {
//    $command->handle(Arguments::fromArgv($argv));
//} catch (CommandException $error) {
//    echo "{$error->getMessage()}\n";
//}

//$postRepository = new SqlitePostRepository($connection);
//$command = new CreatePostCommand($postRepository);
//try {
//    $command->handle(Arguments::fromArgv($argv));
//} catch (CommandException $error) {
//    echo "{$error->getMessage()}\n";
//}

$commentRepository = new SqliteCommentRepository($connection);
$command = new CreateCommentCommand($commentRepository);
try {
    $command->handle(Arguments::fromArgv($argv));
} catch (CommandException $error) {
    echo "{$error->getMessage()}\n";
}