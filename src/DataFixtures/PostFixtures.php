<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    protected $faker;

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();

        for ($i = 0; $i < 13; $i++) {
            $post = (new Post)
                ->setTitle($this->faker->sentence($nbWords = 6, $variableNbWords = true))
                ->setContent($this->faker->paragraph($nbSentences = $this->faker->numberBetween($min = 3, $max = 15), $variableNbSentences = false))
                ->setImageName("img.jpeg")
                ->setCategory($this->getReference(CategoryFixtures::CATEGORY_REFERENCE))
            ;
            $manager->persist($post);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}