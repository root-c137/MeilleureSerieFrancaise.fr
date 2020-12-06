<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Entity\Membre;
use App\Entity\User;
use App\Entity\Votes;
use App\Form\RegisterType;
use DateTimeInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $Rep = $this->getDoctrine()->getRepository(Serie::class);
        $Rep2 = $this->getDoctrine()->getRepository(Votes::class);

        $Series = $Rep->findBy(array(), array('Nb_Vote' => 'DESC'));
        $Total = count($Rep2->findAll());

        $SerieActuel = '';
        if($this->getUser())
        {
            $VoteActuel = $Rep2->findOneBy(['User' => $this->getUser()]);

            if(!is_null($VoteActuel) )
            $SerieActuel = $VoteActuel->getSerie();

        }
        $VoteNull = false;

        if($Total == 0)
        {
            $Total = 1;
            $VoteNull = true;
        }

        return $this->render('home/index.html.twig', [
            'Series' => $Series,
            'Total' => $Total,
            'VoteNull' => $VoteNull,
            'SerieActuel' => $SerieActuel
        ]);
    }





    /**
     * @Route("/NewVote", name="NewVote")
     */
    public function NewVote()
    {
        if($this->getUser()) {
            $E = 0;

            if (!empty($_POST['Vote'])) {
                $Date = date_create()->format('Y-m-d H:i:s');

                $EM = $this->getDoctrine()->getManager();
                $AncienVote = $EM->getRepository(Votes::class)->findOneBy(['User' => $this->getUser()] );

                //Si l'user à déjà voté, et donc il est présent dans la table votes..
                if($AncienVote)
                {
                    //On récupère la série pour laquel il avait voté et on lui enlève 1..
                    $Serie = $EM->getRepository(Serie::class)->find($AncienVote->getSerie());
                    $NbVoteActuel = $Serie->getNbVote();
                    $Serie->setNbVote($NbVoteActuel - 1);

                    $NewSerie = $EM->getRepository(Serie::class)->find($_POST['Vote']);
                    $NbVoteActuel = $NewSerie->getNbVote();
                    $NewSerie->setNbVote($NbVoteActuel + 1);

                    $AncienVote->setSerie($NewSerie);

                }
                else
                 {
                    $Serie = $EM->getRepository(Serie::class)->find($_POST['Vote']);
                    $NbVoteActuel = $Serie->getNbVote();
                    $Serie->setNbVote($NbVoteActuel + 1);

                    $Vote = new Votes();
                    $Vote->setIp($_SERVER['REMOTE_ADDR']);
                    $Vote->setUser($this->getUser());
                    $Vote->setSerie($Serie);
                    $EM->persist($Vote);
                 }

                $EM->flush();

            } else
                $E = 1;

            return $this->redirectToRoute('home');
        }
        else
        {
            return $this->redirectToRoute('app_login');
        }
    }



    private function createFrom(string $class)
    {
    }

}


