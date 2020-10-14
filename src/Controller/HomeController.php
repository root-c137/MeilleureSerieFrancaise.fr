<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Entity\Membre;
use DateTime;
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
        $Series = $Rep->findBy(array(), array('Nb_Vote' => 'DESC'));

        return $this->render('home/index.html.twig', [
            'Series' => $Series
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
            $HachPass = password_hash($Pass, PASSWORD_BCRYPT);
            $Membre = new Membre();
            $Membre->setIP($_SERVER['REMOTE_ADDR'])
                ->setMail($Mail)
                ->setMp($HachPass)
                ->setMpH($Pass)
                ->setPseudo($_POST['Pseudo']);


            $Em = $this->getDoctrine()->getManager();
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

            $EM = $this->getDoctrine()->getManager();
            $Serie = $EM->getRepository(Serie::class)->find($_POST['Vote']);
            $NbVoteActuel = $Serie->getNbVote();

            $Serie->setNbVote($NbVoteActuel+1);

            $EM->flush();

        }
        else
        $E = 1;

        return $this->render('Inscription/test.html.twig',
            [
                "e"=> $E
            ]);
    }



    private function createFrom(string $class)
    {
    }

}


