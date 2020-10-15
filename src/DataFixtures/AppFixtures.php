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

        $Serie4 = new Serie();
        $Serie4->setAuteur("Kyan Khojandi et Bruno Muschio");
        $Serie4->setNom("Engrenages");
        $Serie4->setProposerPar("root");
        $Serie4->setImg("engrenages.jpg" );

        $manager->persist($Serie4);

        $Serie5 = new Serie();
        $Serie5->setAuteur("Kyan Khojandi et Bruno Muschio");
        $Serie5->setNom("Hero Corp");
        $Serie5->setProposerPar("root");
        $Serie5->setImg("herocorp.jpg" );

        $manager->persist($Serie5);

        $Serie6 = new Serie();
        $Serie6->setAuteur("Kyan Khojandi et Bruno Muschio");
        $Serie6->setNom("Le bureau des légendes");
        $Serie6->setProposerPar("root");
        $Serie6->setImg("bureaudeslegendes.jpg" );

        $manager->persist($Serie6);




        $manager->flush();
    }
}
