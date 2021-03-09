<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $post = (new Post)
            ->setTitle('Hello')
            ->setContent("This is my first post")
        ;

        $manager->persist($post);
        $manager->flush();
    }
}
