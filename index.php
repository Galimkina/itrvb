<?php
use Itrvb\galimova\Blog\Post;
use Itrvb\galimova\Blog\User;
use Itrvb\galimova\Blog\Name;
use Itrvb\galimova\Blog\Comment;
use Faker\Factory;

require_once __DIR__ . '/vendor/autoload.php';

//spl_autoload_register(function ($class) {
// 	$file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
//
// 	if (file_exists($file)) {
// 		require "$class.php";
// 	}
// });

//$faker = Factory::create('ru_RU');
//
//$user = new User(
//    uuid: $faker->uuid,
//    username: $faker->name,
//    name: new Name( $faker->firstName(),  $faker->lastName()),
//);
//$post = new Post(
//    uuid: $faker->uuid,
//    author_uuid:  $faker->uuid,
//    title: $faker->realText(10),
//    text: $faker->realText
//);
//$comment = new Comment(
//    uuid: $faker->uuid,
//    author_uuid: $faker->uuid,
//    post_uuid: $faker->uuid,
//    text:  $faker->realText
//);
//echo $user."<p>".$post."<p>".$comment;

