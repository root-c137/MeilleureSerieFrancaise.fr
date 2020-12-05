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

                $Serie = $EM->getRepository(Serie::class)->find($_POST['Vote']);

                $NbVoteActuel = $Serie->getNbVote();
                $Serie->setNbVote($NbVoteActuel + 1);

                $Vote = new Votes();
                $Vote->setIp($_SERVER['REMOTE_ADDR']);
                $EM->persist($Vote);

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


