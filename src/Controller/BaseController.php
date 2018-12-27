<?php

namespace App\Controller;

use App\Entity\View;
use App\Service\Event\EventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{

    private $sEvent;

    public function __construct( EventService $sEvent )
    {
        $this->sEvent = $sEvent;
    }

    /**
     * @Route("/", name="home")
     */
    public function home() {

        $event = $this->sEvent->getTheEvent();

        return $this->render('envol/home.html.twig', [
            'event' => $event
        ]);
    }

    /**
     * @Route("/page/{slug}", name="page")
     */
    public function textView( View $view ) {

        $page = $this->container->get('twig')->createTemplate( $view->getContent() ?? '' )->render( [] );

        return $this->render('envol/pages/page.html.twig', array(
            'title' => [
                'pic' => $view->getMenu()->getImage(),
                'name' => $view->getMenu()->getName(),
                'color' => $view->getMenu()->getColor(),
            ],
            'view' => $view,
            'page' => $page,
        ));

    }
}