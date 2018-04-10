<?php

namespace App\Controller;
use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\Round;
use App\Entity\View;
use App\Form\RoleplayEventType;
use App\Service\TimeZones;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RoleplayController extends Controller
{

    private $timezones;

    private const EVENT_TYPE_NAME = 'roleplay';

    public function __construct( TimeZones $timeZones )
    {
        $this->timezones = $timeZones;
    }

    /**
     * @Route("/jeu-de-roles/test", name="roleplay.test")
     */
    public function date(  ) {

        $title = [
            'color' =>  'bd-orange',
            'pic' => 'images/title/jdr.png',
            'name' => 'Jeu de rôle',
        ];

        $page = 'YOLO';

        return $this->render('envol/standard.html.twig', array(
            'title' => $title,
            'page' => $page,
        ));

    }

    /**
     * @Route("/jeu-de-roles/ajouter/{time}", name="roleplay.add")
     */
    public function add( $time = false,  Request $request ) {

        $round = $this->getRoundFromTimecode( $time, $rounds );

        $event = new Event();
        $event->setRound($round);

        $form = $this->createForm( RoleplayEventType::class, $event );


        $form->handleRequest( $request );
        if ( $form->isSubmitted() && $form->isValid() ) {
            dump($request);
        }




        $title = [
            'color' =>  'bd-orange',
            'pic' => 'images/title/jdr.png',
            'name' => 'Jeu de rôle',
        ];

        return $this->render('envol/pages/roleplay-add-event.html.twig', array(
            'title' => $title,
            'form' => $form->createView(),
        ));

    }

    /**
     * @Route("/jeu-de-roles/{time}", name="roleplay")
     */
    public function home( $time = false ) {

        $round = $this->getRoundFromTimecode( $time, $rounds );

        $eventType = $this->getDoctrine()->getRepository( EventType::class )->findOneBy( ['name' => self::EVENT_TYPE_NAME] );

        $events = $this->getDoctrine()->getRepository(Event::class )
            ->findBy( [
                'round' => $round,
                'eventType' => $eventType,
                ] );

        $title = [
            'color' =>  'bd-orange',
            'pic' => 'images/title/jdr.png',
            'name' => 'Jeu de rôle',
        ];

        return $this->render('envol/pages/roleplay-list.html.twig', array(
            'title' => $title,
            'active_tab' => $time,
            'rounds' => $rounds,
            'events' => $events,
        ));
    }

    private function getRoundFromTimecode( &$time, &$rounds ) {

        $rounds = $this->timezones->getByEventName( self::EVENT_TYPE_NAME );

        if( !$this->timezones->checkTimeCode( $time ) ) {
            $time = key( $rounds );
        }

        return $this->getDoctrine()->getRepository( Round::class )->findOneBy( ['code' => $time] );

    }
}