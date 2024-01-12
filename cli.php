<?php
use Itrvb\galimova\Blog\Commands\Arguments;
use Itrvb\galimova\Blog\Commands\CreateCommentCommand;
use Itrvb\galimova\Blog\Commands\CreateLikeCommand;
use Itrvb\galimova\Blog\Commands\CreateLikeCommentCommand;
use Itrvb\galimova\Blog\Commands\CreatePostCommand;
use Itrvb\galimova\Blog\Commands\CreateUserCommand;
use Itrvb\galimova\Blog\Commands\FakeData\PopulateDB;
use Itrvb\galimova\Blog\Exceptions\CommandException;
use Itrvb\galimova\Blog\Http\Actions\Comments\CreateComment;
use Itrvb\galimova\Blog\Http\Actions\Posts\CreatePost;
use Itrvb\galimova\Blog\Http\Actions\Posts\DeletePost;
use Itrvb\galimova\Blog\Http\Actions\Likes\CreateLike;
use Itrvb\galimova\Blog\Http\Actions\Likes\CreateLikeComment;
use Itrvb\galimova\Blog\Http\Actions\Users\CreateUser;
use Itrvb\galimova\Blog\Repositories\CommentsRepository\SqliteCommentRepository;
use Itrvb\galimova\Blog\Repositories\LikesRepository\SqliteLikeCommentRepository;
use Itrvb\galimova\Blog\Repositories\LikesRepository\SqliteLikeRepository;
use Itrvb\galimova\Blog\Repositories\PostsRepository\SqlitePostRepository;
use Itrvb\galimova\Blog\Repositories\UserRepository\SqliteUsersRepository;
use Symfony\Component\Console\Application;

$container = require __DIR__ . '/bootstrap.php';
$application = new Application();

$commandsClasses = [
    PopulateDB::class
];

foreach ($commandsClasses as $commandClass)
{
    $command = $container->get($commandClass);

    $application->add($command);
}
$application->run();

$command = $container->get(CreateUserCommand::class);
try {
    $command->handle(Arguments::fromArgv($argv));
} catch (CommandException $error) {
    echo "{$error->getMessage()}\n";
}

//$command = $container->get(CreatePostCommand::class);
//try {
//    $command->handle(Arguments::fromArgv($argv));
//} catch (CommandException $error) {
//    echo "{$error->getMessage()}\n";
//}

//$command = $container->get(CreateCommentCommand::class);
//try {
//    $command->handle(Arguments::fromArgv($argv));
//} catch (CommandException $error) {
//    echo "{$error->getMessage()}\n";
//}

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