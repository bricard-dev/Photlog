<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PostFixtures extends Fixture
{
    protected $faker;

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();

        for ($i = 0; $i < 6; $i++) {
            $post = (new Post)
                ->setTitle($this->faker->sentence($nbWords = 6, $variableNbWords = true))
                ->setContent($this->faker->text());
            ;
            $manager->persist($post);
        }
        $manager->flush();
    }
}