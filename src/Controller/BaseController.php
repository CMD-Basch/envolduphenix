<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\View;
use App\Service\Event\EventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class BaseController extends AbstractController
{

    private $sEvent;
    private $theEvent;

    public function __construct( EventService $sEvent )
    {
        $this->sEvent = $sEvent;
        $this->theEvent = $sEvent->getTheEvent();
    }

    /**
     * @Route("/", name="home")
     */
    public function home() {

        $event  = $this->theEvent;
        if( !$event ) return $this->render('envol/no_event.html.twig' );

        return $this->render('envol/home.html.twig', [
            'event' => $event
        ]);
    }

    /**
     * @Route("/page/{longSlug}", name="page", requirements={"longSlug"="[^\/]+\/[^\/]+"} )
     */
    public function textView( View $view, Environment $twig ) {

        $page = $twig->createTemplate( $view->getContent() ?? '' )->render( [] );

        if( $view->getModule() ){
            return $this->redirectToRoute( 'activity.module.list', [ 'slug' => $view->getModule()->getSlug() ] );
        }

        return $this->render('envol/pages/page.html.twig', array(
            'title' => $view->generateTitle(),
            'view' => $view,
            'page' => $page,
        ));

    }
}