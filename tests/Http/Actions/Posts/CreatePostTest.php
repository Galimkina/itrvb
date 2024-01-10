<?php

namespace Itrvb\galimova\Blog\UnitTests\Http\Actions\Articles;

use Itrvb\galimova\Blog\Exceptions\InvalidArgumentException;
use Itrvb\galimova\Blog\Http\Actions\Posts\CreatePost;
use Itrvb\galimova\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Itrvb\galimova\Blog\Exceptions\UserNotFoundException;
use Itrvb\galimova\Blog\Http\ErrorResponse;
use Itrvb\galimova\Blog\Http\Request;
use Itrvb\galimova\Blog\Http\SuccessfulResponse;
use Itrvb\galimova\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Itrvb\galimova\Blog\Name;
use Itrvb\galimova\Blog\User;
use Itrvb\galimova\Blog\UUID;

class CreatePostTest extends TestCase {
    public function testSuccessResponse() {
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $userRepository->expects($this->once())
            ->method('get')
            ->willReturn(
                new User(UUID::random(), 'galimkina', new Name('Nastya', 'Galimova'))
            );

        $postsRepository = $this->createMock(PostsRepositoryInterface::class);
        $postsRepository->expects($this->once())
            ->method('save');

        $createPosts = new CreatePost($postsRepository, $userRepository);

        $request = new Request([], [], '{
            "author_uuid": "dada55c2-b9a4-4b2f-aa60-a4139b544093",
            "title": "Itrvb",
            "text": "Vsem privet"
        }');

        $response = $createPosts->handle($request);
        $this->assertInstanceOf(SuccessfulResponse::class, $response);
    }

    public function testInvalidUuidFormat() {
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $postsRepository = $this->createMock(PostsRepositoryInterface::class);

        $createPosts = new CreatePost($postsRepository, $userRepository);

        $request = new Request([], [], '{
            "author_uuid": "dada55c2-b9a4-4b2f-aa60-a4139b5440",
            "title": "Itrvb",
            "text": "Vsem privet"
        }');

        $this->expectException(InvalidArgumentException::class);
        $createPosts->handle($request);
    }

    public function testNotFoundUserByUuid() {
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $userRepository->method('get')->willThrowException(new UserNotFoundException());

        $postsRepository = $this->createMock(PostsRepositoryInterface::class);

        $createPosts = new CreatePost($postsRepository, $userRepository);

        $request = new Request([], [], '{
            "author_uuid": "dada55c2-b9a4-4b2f-aa60-a4139b544090",
            "title": "Itrvb",
            "text": "Vsem privet"
        }');

        $this->expectException(UserNotFoundException::class);
        $createPosts->handle($request);
    }

    public function testNotAllData() {
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $postsRepository = $this->createMock(PostsRepositoryInterface::class);

        $createPosts = new CreatePost($postsRepository, $userRepository);

        $request = new Request([], [], '{
            "author_uuid": "dada55c2-b9a4-4b2f-aa60-a4139b544093",
            "title": "Itrvb"
        }');

        $this->assertInstanceOf(ErrorResponse::class, $createPosts->handle($request));
        $this->expectOutputString('');
        $createPosts->handle($request);
    }
}

