<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use App\DataFixtures\Record;

abstract class AppFixtures extends Fixture
{
    /** @var ObjectManager */
    private ObjectManager $manager;

    /** @var Generator */
    protected Generator $faker;

    abstract public function doLoad(): void;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = Factory::create();

        $this->doLoad();
        $this->manager->flush();
    }

    public function create(string $className,  callable $factory)
    {
        for ($i = 0; $i < 7; $i++){
            $entity = new $className();
            $factory($entity, $i);

            $this->manager->persist($entity);

        }
    }


}