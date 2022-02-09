<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Commercial;
use App\Entity\Maison;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        // $commercial = new Commercial(); // crée un nouveau commercial
        // $commercial->setName('David'); // définit le nom du commercial
        // $manager->persist($commercial); // précise au gestionnaire qu'on va vouloir envoyer un objet en base de données (le rend persistant / liste d'attente)

        $faker = Factory::create();

        for ($i = 1; $i <= 5; $i++) {
            $commercial = new Commercial();
            $commercial->setName($faker->name());
            $manager->persist($commercial);
        }

        for ($i = 1; $i <= 10; $i++) {
            $maison = new Maison();
            $maison->setTitle('Maison de ' . $faker->name());
            $maison->setDescription($faker->text(255));
            $maison->setSurface($faker->numberBetween(59, 199));
            $maison->setRooms($faker->numberBetween(5, 10));
            $maison->setBedrooms($faker->numberBetween(1, 4));
            $maison->setPrice($faker->numberBetween(75000, 580000));
            $maison->setImg1('maison-1.png');
            $maison->setImg2('maison-2.png');
            $maison->setCommercial($commercial);
            $manager->persist($maison);
        }

        $manager->flush(); // envoit les objets persistés en base de données
    }
}
