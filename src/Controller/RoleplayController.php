<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\Round;
use App\Form\RoleplayEventType;
use App\Service\EventUser;
use App\Service\TimeZones;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class RoleplayController extends Controller
{

    private $timezones;
    private $eventUser;
    private $user;

    public const EVENT_TYPE_NAME = 'roleplay';

    public function __construct( TimeZones $timeZones, TokenStorageInterface $tokenStorage, EventUser $eventUser )
    {
        $this->timezones = $timeZones;
        $this->eventUser = $eventUser;

        if( get_class($tokenStorage->getToken() ) == UsernamePasswordToken::class ) { // TODO : checker autrement
            $this->user = $tokenStorage->getToken()->getUser();
        }
    }

    /**
     * @Route("/jeu-de-roles/ajax/{act}/{id}", name="roleplay.join")
     */
    public function ajax( $act, Event $event ) {

        $this->denyAccessUnlessGranted( 'IS_AUTHENTICATED_REMEMBERED' );

        $eventType = $this->getDoctrine()->getRepository(EventType::class )->findOneBy( ['name' => self::EVENT_TYPE_NAME] );
        $round = $event->getRound();
        $events = $this->getDoctrine()->getRepository(Event::class )
            ->findBy( [
                'round' => $round,
                'eventType' => $eventType,
            ] );

        switch( $act ){
            case 'join' :
                if( $this->eventUser->isEventTimeFree( $event ) ) {

                    $event->addPlayer( $this->user );
                    $this->getDoctrine()->getManager()->flush();

                    return $this->render('envol/block/roleplay-events.html.twig',[ 'events' => $events, ]);
                }
                break;
            case 'leave' :
                $event->removePlayer( $this->user );
                $this->getDoctrine()->getManager()->flush();

                return $this->render('envol/block/roleplay-events.html.twig',[ 'events' => $events, ]);
                break;
        }

        return null;
    }

    /**
     * @Route("/jeu-de-roles/ajouter/{time}", name="roleplay.add")
     */
    public function add( $time = false,  Request $request ) {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $round = $this->getRoundFromTimeCode( $time, $rounds );

        $event = new Event();
        $event->setRound( $round );

        $form = $this->createForm( RoleplayEventType::class, $event );

        $form->handleRequest( $request );
        if ( $form->isSubmitted() && $form->isValid() ) {

            if( $this->eventUser->isRoundTimeFree( $round ) ) {
                $eventType = $this->getDoctrine()->getRepository(EventType::class )->findOneBy( ['name' => self::EVENT_TYPE_NAME] );

                $event
                    ->setEventType( $eventType )
                    ->setMaster( $this->getUser() );

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist( $event );
                $entityManager->flush();

                return $this->redirectToRoute('roleplay', ['time' => $event->getRound()->getCode()]);
            }
        }

        $title = [
            'color' =>  'bd-orange',
            'pic' => 'images/title/jdr.png',
            'name' => 'Jeu de rôle',
        ];

        return $this->render('envol/pages/roleplay-add-event.html.twig', [
            'title' => $title,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/jeu-de-roles/{time}", name="roleplay")
     */
    public function home( $time = false ) {

        $round = $this->getRoundFromTimeCode( $time, $rounds );
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
            'active_round' => $round,
            'rounds' => $rounds,
            'events' => $events,
        ));
    }

    private function getRoundFromTimeCode( &$time, &$rounds ) {

        $rounds = $this->timezones->getByEventName( self::EVENT_TYPE_NAME );

        if( !$this->timezones->checkTimeCode( $time ) ) {
            $time = key( $rounds );
        }

        return $this->getDoctrine()->getRepository( Round::class )->findOneBy( ['code' => $time] );

    }
}