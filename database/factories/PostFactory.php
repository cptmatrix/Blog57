<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Post::class, function (Faker $faker) {
    $images=['about-bg.jpg', 'contact-bg.jpg', 'home-bg.jpg', 'post-bg.jpg'];
    $title=$faker->sentence(mt_rand(3,10));
    return [
        //
        'title'=>$title,
        'subtitle'=>str_limit($faker->sentence(mt_rand(1,10)),10),
        'page_image'=>$images[mt_rand(0,3)],
        'content_raw'=>join('\n\n',$faker->paragraphs(mt_rand(3,60))),
        'publish_at'=>$faker->dateTimeBetween('-1 month','+3 days'),
        'meta_description'=>"meta for $title",
        'is_draft'=>false,
    ];
});
