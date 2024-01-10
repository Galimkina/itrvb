<?php
use Itrvb\galimova\Blog\Exceptions\HttpException;
use Itrvb\galimova\Blog\Http\Actions\Posts\DeletePost;
use Itrvb\galimova\Blog\Http\Actions\Posts\CreatePost;
use Itrvb\galimova\Blog\Http\Actions\Users\CreateUser;
use Itrvb\galimova\Blog\Http\Actions\Comments\CreateComment;
use Itrvb\galimova\Blog\Http\Actions\Users\FindByUsername;
use Itrvb\galimova\Blog\Http\ErrorResponse;
use Itrvb\galimova\Blog\Http\Request;

$container = require __DIR__ . '/bootstrap.php';

$request = new Request($_GET, $_SERVER, file_get_contents('php://input'));

try {
    $path = $request->path();
} catch (HttpException) {
    (new ErrorResponse)->send();
    return;
}

try {
    $method = $request->method();
} catch (HttpException) {
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
    ],
    'DELETE' => [
        '/posts/delete' => DeletePost::class,
    ],
];

if (!array_key_exists($method, $routes) || !array_key_exists($path, $routes[$method])) {
    $message = "Route not found: $method $path";
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
    (new ErrorResponse($error->getMessage()))->send();
}

$response->send();