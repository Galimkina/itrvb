<?php
use Itrvb\galimova\Blog\Commands\Arguments;
use Itrvb\galimova\Blog\Commands\CreateCommentCommand;
use Itrvb\galimova\Blog\Commands\CreateLikeCommand;
use Itrvb\galimova\Blog\Commands\CreateLikeCommentCommand;
use Itrvb\galimova\Blog\Commands\CreatePostCommand;
use Itrvb\galimova\Blog\Commands\CreateUserCommand;
use Itrvb\galimova\Blog\Exceptions\CommandException;
use Itrvb\galimova\Blog\Repositories\CommentsRepository\SqliteCommentRepository;
use Itrvb\galimova\Blog\Repositories\LikesRepository\SqliteLikeCommentRepository;
use Itrvb\galimova\Blog\Repositories\LikesRepository\SqliteLikeRepository;
use Itrvb\galimova\Blog\Repositories\PostsRepository\SqlitePostRepository;
use Itrvb\galimova\Blog\Repositories\UserRepository\SqliteUsersRepository;

$container = require __DIR__ . '/bootstrap.php';

//$command = $container->get(CreateUserCommand::class);
//try {
//    $command->handle(Arguments::fromArgv($argv));
//} catch (CommandException $error) {
//    echo "{$error->getMessage()}\n";
//}

//$command = $container->get(CreatePostCommand::class);
//try {
//    $command->handle(Arguments::fromArgv($argv));
//} catch (CommandException $error) {
//    echo "{$error->getMessage()}\n";
//}

$command = $container->get(CreateCommentCommand::class);
try {
    $command->handle(Arguments::fromArgv($argv));
} catch (CommandException $error) {
    echo "{$error->getMessage()}\n";
}

//$command = $container->get(CreateLikeCommand::class);
//try {
//    $command->handle(Arguments::fromArgv($argv));
//} catch (CommandException $error) {
//    echo "{$error->getMessage()}\n";
//}

//$command = $container->get(CreateLikeCommentCommand::class);
//try {
//    $command->handle(Arguments::fromArgv($argv));
//} catch (CommandException $error) {
//    echo "{$error->getMessage()}\n";
//}