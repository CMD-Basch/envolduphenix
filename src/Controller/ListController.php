<?php

namespace App\Controller;
use App\Entity\Parrainer;
use App\Entity\Round;
use App\Entity\View;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ListController extends Controller
{

    /**
     * @Route("/show/{id}", name="listeprojo")
     */
    public function textView( Round $round ) {

        return $this->render('screen/roleplay-event-list.html.twig', [
            'round' => $round
        ]);

    }
}