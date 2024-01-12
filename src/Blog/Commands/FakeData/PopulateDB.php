<?php

namespace Itrvb\galimova\Blog\Commands\FakeData;

use Faker\Generator;
use Itrvb\galimova\Blog\Comment;
use Itrvb\galimova\Blog\Name;
use Itrvb\galimova\Blog\Post;
use Itrvb\galimova\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;
use Itrvb\galimova\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use Itrvb\galimova\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Itrvb\galimova\Blog\User;
use Itrvb\galimova\Blog\UUID;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class PopulateDB extends Command
{
    public function __construct(
        private Generator                $faker,
        private UserRepositoryInterface  $userRepository,
        private PostsRepositoryInterface $postsRepository,
        private CommentsRepositoryInterface $commentsRepository
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('fake-data:populate-db')
            ->setDescription('Populates DB with fake data')
            ->addArgument('user number', InputArgument::REQUIRED, 'number')
            ->addArgument('post number', InputArgument::REQUIRED, 'number');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = [];
        $userNumber = $input->getArgument('user number');
        $postNumber = $input->getArgument('post number');

        for ($i = 0; $i < $userNumber; $i++) {
            $user = $this->createFakeUser();
            $users[] = $user;
            $output->writeln('User created ' . $user->username);
        }

        foreach ($users as $user)
        {
            for ($i = 0; $i < $postNumber; $i++) {
                $post = $this->createFakePost($user);
                $comment = $this->createFakeComment($user, $post);
                $output->writeln('Post created ' . $post->title);
                $output->writeln('Comment created' . $comment->text);
            }
        }
        return Command::SUCCESS;
    }

    private function createFakeUser(): User
    {
        $user = User::createFrom(
            username: $this->faker->userName(),
            name: new Name(
                firstName: $this->faker->firstName(), lastName: $this->faker->lastName(),
            ),
        );

        $this->userRepository->save($user);

        return $user;
    }

    private function createFakePost(User $user): Post
    {
        $post = new Post(
            uuid: UUID::random(),
            author_uuid: $user->getUUID(),
            title: $this->faker->realText(10),
            text: $this->faker->realText(20),
        );

        $this->postsRepository->save($post);

        return $post;
    }

    private function createFakeComment(User $user, Post $post): Comment
    {
        $comment = new Comment(
            uuid: UUID::random(),
            author_uuid: $user->getUUID(),
            post_uuid: $post->uuid,
            text: $this->faker->realText(20),
        );
        $this->commentsRepository->save($comment);
        return $comment;
    }
}