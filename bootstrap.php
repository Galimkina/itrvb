<?php

use Itrvb\galimova\Blog\Container\DIContainer;
use Itrvb\galimova\Blog\Repositories\LikesRepository\LikesCommentRepositoryInterface;
use Itrvb\galimova\Blog\Repositories\LikesRepository\LikesRepositoryInterface;
use Itrvb\galimova\Blog\Repositories\LikesRepository\SqliteLikeCommentRepository;
use Itrvb\galimova\Blog\Repositories\LikesRepository\SqliteLikeRepository;
use Itrvb\galimova\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use Itrvb\galimova\Blog\Repositories\PostsRepository\SqlitePostRepository;
use Itrvb\galimova\Blog\Repositories\UserRepository\SqliteUsersRepository;
use Itrvb\galimova\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Itrvb\galimova\Blog\Repositories\CommentsRepository\SqliteCommentRepository;
use Itrvb\galimova\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Faker\Generator;
use Faker\Provider\ru_RU\Person;
use Faker\Provider\ru_RU\Text;
use Faker\Provider\ru_RU\Internet;

require_once __DIR__ . '/vendor/autoload.php';

$container = new DIContainer;

$faker = new Generator();

$faker->addProvider(new Person($faker));
$faker->addProvider(new Text($faker));
$faker->addProvider(new Internet($faker));

$container->bind(PDO::class, new PDO('sqlite:' . __DIR__ . '/blog.sqlite'));

$container->bind(UserRepositoryInterface::class, SqliteUsersRepository::class);
$container->bind(PostsRepositoryInterface::class, SqlitePostRepository::class);
$container->bind(CommentsRepositoryInterface::class, SqliteCommentRepository::class);
$container->bind(LikesRepositoryInterface::class, SqliteLikeRepository::class);
$container->bind(LikesCommentRepositoryInterface::class, SqliteLikeCommentRepository::class);
$container->bind(Generator::class, $faker);

$logger = (new Logger('blog'));

$container->bind(LoggerInterface::class, $logger
    ->pushHandler(new StreamHandler(__DIR__ . '/logs/blog.log'))
    ->pushHandler(new StreamHandler(
        __DIR__ . '/logs/blog.error.log',
        level: Level::Error,
        bubble: false
    ))
    ->pushHandler(new StreamHandler("php://stdout"))
);

return $container;
