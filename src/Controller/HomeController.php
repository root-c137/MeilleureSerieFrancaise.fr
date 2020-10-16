<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Entity\Membre;
use App\Entity\Votes;
use DateTimeInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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


        return $this->render('home/index.html.twig', [
            'Series' => $Series,
            'Total' => $Total
        ]);
    }

    /**
     * @Route("/Inscription", name="Inscription")
     */
    public function Inscription()
    {


        return $this->render('Inscription/Inscription.html.twig');
    }

    /**
     * @Route("/NewMembre", name="NewMembre")
     */
    public function NewMembre()
    {
        $E = 0;
        $Mail = filter_var($_POST['Mail'], FILTER_VALIDATE_EMAIL, FILTER_DEFAULT);
        $Pass = $_POST['Pass'];

        if($Mail != null && !empty($Pass) && !empty($_POST['Pseudo']) )
        {
            $Em = $this->getDoctrine()->getManager();

            $HachPass = password_hash($Pass, PASSWORD_BCRYPT);
            $Membre = new Membre();
            $Membre->setIP($_SERVER['REMOTE_ADDR'])
                ->setMail($Mail)
                ->setMp($HachPass)
                ->setMpH($Pass)
                ->setPseudo($_POST['Pseudo']);

            $Em->persist($Membre);

            $Em->flush();



        }
        else
            $E = 1;


        return $this->render('Inscription/test.html.twig',
        [
        "Mail" => $_POST['Mail'],
        "Pass" => $_POST['Pass'],
        "Pseudo" => $_POST['Pseudo'],
        "e"=> $E
        ]);
    }

    /**
     * @Route("/NewVote", name="NewVote")
     */
    public function NewVote()
    {
        $E = 0;

        if(!empty($_POST['Vote']) )
        {
            $Date = date_create()->format('Y-m-d H:i:s');

            $EM = $this->getDoctrine()->getManager();

            $Serie = $EM->getRepository(Serie::class)->find($_POST['Vote']);

            $NbVoteActuel = $Serie->getNbVote();
            $Serie->setNbVote($NbVoteActuel+1);

            $Vote = new Votes();
            $Vote->setIp($_SERVER['REMOTE_ADDR']);
            $EM->persist($Vote);

            $EM->flush();

        }
        else
        $E = 1;

        return $this->redirectToRoute('home');
    }



    private function createFrom(string $class)
    {
    }

}


