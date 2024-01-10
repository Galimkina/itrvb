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

require_once __DIR__ . '/vendor/autoload.php';

$container = new DIContainer;

$container->bind(PDO::class, new PDO('sqlite:' . __DIR__ . '/blog.sqlite'));

$container->bind(UserRepositoryInterface::class, SqliteUsersRepository::class);
$container->bind(PostsRepositoryInterface::class, SqlitePostRepository::class);
$container->bind(CommentsRepositoryInterface::class, SqliteCommentRepository::class);
$container->bind(LikesRepositoryInterface::class, SqliteLikeRepository::class);
$container->bind(LikesCommentRepositoryInterface::class, SqliteLikeCommentRepository::class);


return $container;
