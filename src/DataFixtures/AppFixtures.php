<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //création de faker
        require_once 'vendor/autoload.php';

        $faker = Faker\Factory::create('fr_FR');

        //boucle de création
        for ($i = 0; $i < 5; $i++) {

            $category = new Category();

            $category->setName($faker->safeColorName())
                ->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($category);
            $manager->flush();

            for ($j=0; $j<3; $j++){
                //Création et repmlissage d'un nouveau produit (preparation objet)
                $product = new Product();
                $product->setName($faker->name)
                    ->setPrice($faker->randomFloat(2, 1, 50))
                    ->setDescription($faker->paragraph(5))
                    ->setCategory($category)
                ;

                //persister l'objet en bdd (preparation requete)
                $manager->persist($product);

                // (on execute la requete)
                $manager->flush();
            }

        }

    }
}
