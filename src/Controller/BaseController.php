<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\View;
use App\Service\Event\EventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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

        return $this->render('envol/home.html.twig', [
            'event' => $this->theEvent
        ]);
    }

    /**
     * @Route("/page/{longSlug}", name="page", requirements={"longSlug"="[^\/]+\/[^\/]+"} )
     */
    public function textView( View $view ) {

        $page = $this->container->get('twig')->createTemplate( $view->getContent() ?? '' )->render( [] );

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