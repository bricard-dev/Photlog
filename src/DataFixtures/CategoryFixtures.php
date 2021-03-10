<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public const CATEGORY_REFERENCE = 'category';

    protected $faker;

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();

        $category = (new Category)
            ->setName(ucfirst($this->faker->word))
        ;

        $manager->persist($category);
        $manager->flush();

        $this->addReference(self::CATEGORY_REFERENCE, $category);
    }
}
