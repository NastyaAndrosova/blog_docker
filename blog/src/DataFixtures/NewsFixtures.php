<?php

namespace App\DataFixtures;

use App\Entity\News;

class NewsFixtures extends AppFixtures
{
    private static array $images = ['black.png', 'blue.png', 'green.png', 'orange.png', 'purple.png', 'red.png', 'white.png',
        'yellow.png'];

    private static array $tags = ['#sport, #business', '#music, #business, #cars', '#business, #sport',
        '#sport, #fails', '#surgery', '#business, #dance, #nature', '#business, #science'];


    public function doLoad(): void
    {
        $this->create(News::class, function (News $news, $count){
            $news->setName($this->faker->name);
            $news->setTags(self::$tags[$count]);
            $news->setText($this->faker->text);
            $news->setDate($this->faker->dateTime());
            $news->setPhoto(self::$images[$count]);
        });
    }
}
