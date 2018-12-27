<?php

namespace App\Controller;

use App\Service\Event\EventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function home( EventService $sEvent ) {

        $event = $sEvent->getTheEvent();

        return $this->render('envol/home.html.twig', [
            'event' => $event,
        ]);
    }

}