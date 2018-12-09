<?php

namespace App\Controller;

use App\Entity\Parrainer;
use App\Entity\View;
use App\Service\SiteGlobals;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class TestController extends Controller
{
    /**
     * @Route("/test", name="test")
     */
    public function home(SiteGlobals $siteGlobals) {

        dump($siteGlobals->getEventsToCome());

        $parrainers = $this->getDoctrine()->getRepository( Parrainer::class )->findBy([], ['weight' => 'ASC'] );

        return $this->render('envol/home.html.twig', ['parrainers' => $parrainers]);
    }

}