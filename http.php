<?php
use Itrvb\galimova\Blog\Exceptions\HttpException;
use Itrvb\galimova\Blog\Http\Actions\Likes\CreateLike;
use Itrvb\galimova\Blog\Http\Actions\Likes\CreateLikeComment;
use Itrvb\galimova\Blog\Http\Actions\Posts\DeletePost;
use Itrvb\galimova\Blog\Http\Actions\Posts\CreatePost;
use Itrvb\galimova\Blog\Http\Actions\Users\CreateUser;
use Itrvb\galimova\Blog\Http\Actions\Comments\CreateComment;
use Itrvb\galimova\Blog\Http\Actions\Users\FindByUsername;
use Itrvb\galimova\Blog\Http\ErrorResponse;
use Itrvb\galimova\Blog\Http\Request;
use Psr\Log\LoggerInterface;

$container = require __DIR__ . '/bootstrap.php';

$request = new Request($_GET, $_SERVER, file_get_contents('php://input'));

$logger = $container->get(LoggerInterface::class);

try {
    $path = $request->path();
} catch (HttpException $error) {
    $logger->warning($error->getMessage());
    (new ErrorResponse)->send();
    return;
}

try {
    $method = $request->method();
} catch (HttpException $error) {
    $logger->warning($error->getMessage());
    (new ErrorResponse)->send();
    return;
}

$routes = [
    'GET' => [
        '/users/show' => FindByUsername::class,
    ],
    'POST' => [
        '/users/create' => CreateUser::class,
        '/posts/create' => CreatePost::class,
        '/comments/create' => CreateComment::class,
        '/likes/create' => CreateLike::class,
        '/likesComment/create' => CreateLikeComment::class,

    ],
    'DELETE' => [
        '/posts/delete' => DeletePost::class,
    ],
];

if (!array_key_exists($method, $routes) || !array_key_exists($path, $routes[$method])) {
    $message = "Route not found: $method $path";
    $logger->notice($message);
    (new ErrorResponse($message))->send();
    return;
}

$actionClassName = $routes[$method][$path];
$action = $container->get($actionClassName);

try {
    if (is_callable($action)) {
        $response = $action($_GET['uuid'] ?? '');
    }
    else {
        $response = $action->handle($request);
    }
} catch (Exception $error) {
    $logger->error($error->getMessage(), ['exception' => $error]);
    (new ErrorResponse)->send();
}

$response->send();