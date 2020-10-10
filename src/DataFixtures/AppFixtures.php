<?php

namespace App\DataFixtures;

use App\Entity\Serie;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $Date = DateTime::createFromFormat('Y-m-d', 'H:i:s');


        $Serie = new Serie();
        $Serie->setAuteur("Alexandre Astier");
        $Serie->setNom("Kaameloot");
        $Serie->setProposerPar("root");
        $Serie->setImg("kaamelott.jpg" );

        $manager->persist($Serie);

        $Serie2 = new Serie();
        $Serie2->setAuteur(" ");
        $Serie2->setNom("H");
        $Serie2->setProposerPar("root");
        $Serie2->setImg("h.jpg" );


        $manager->persist($Serie2);

        $Serie3 = new Serie();
        $Serie3->setAuteur("Kyan Khojandi et Bruno Muschio");
        $Serie3->setNom("Bref.");
        $Serie3->setProposerPar("root");
        $Serie3->setImg("bref.jpg" );


        $manager->persist($Serie3);



        $manager->flush();
    }
}
