<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setName("product " . $i);
            $product->setDescription("description product " . $i);
            $product->setVolume(mt_rand(10, 100));
            $product->setWeight(mt_rand(1, 100));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
