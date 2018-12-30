<?php

namespace App\Controller;

use App\Service\Event\EventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ActivityController extends AbstractController
{
    private $sEvent;
    private $theEvent;

    public function __construct( EventService $sEvent )
    {
        $this->sEvent = $sEvent;
        $this->theEvent = $sEvent->getTheEvent();
    }

    /**
     * @Route("/activites/liste", name="activity.list")
     */
    public function listAction() {


        return $this->render('envol/pages/activity/list.html.twig', [
            'event' => $this->theEvent
        ]);
    }


}