<?php
require_once __DIR__ . '/vendor/autoload.php';

use Itrvb\galimova\Blog\Post;
use Itrvb\galimova\Person\Person;
use Itrvb\galimova\Person\Name;
use Itrvb\galimova\Blog\Comment;
use Faker\Factory;

//spl_autoload_register(function ($class) {
// 	$file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
//
// 	if (file_exists($file)) {
// 		require "$class.php";
// 	}
// });

$faker = Factory::create('ru_RU');

$user = new Person(
    id: $faker->randomNumber(2),
    name: new Name( $faker->firstName(),  $faker->lastName()),
    regiseredOn: new DateTimeImmutable()
);
$post = new Post(
    id: $faker->randomNumber(2),
    author_id:  $faker->randomNumber(2),
    title: $faker->realText(10),
    text: $faker->realText
);
$comment = new Comment(
    id: $faker->randomNumber(2),
    author_id: $faker->randomNumber(2),
    post_id: $faker->randomNumber(2),
    text:  $faker->realText
);
echo $user."<p>".$post."<p>".$comment;

//$post = new Post(
//    author: new Person(
//        name: new Name('Ivan', 'Ivanov'),
//        regiseredOn: new DateTimeImmutable(),
//    ),
//    text: 'Vsem privet',
//);
