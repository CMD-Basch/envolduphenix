<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\Round;
use App\Entity\User;
use App\Form\BoardgameEventType;
use App\Form\RoleplayEventType;
use App\Service\EventUser;
use App\Service\TimeZones;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class BoradgameController extends Controller
{

    private $timezones;
    private $eventUser;
    private $user;

    public const EVENT_TYPE_NAME = 'boardgame';

    public function __construct( TimeZones $timeZones, TokenStorageInterface $tokenStorage, EventUser $eventUser)
    {
        $this->timezones = $timeZones;
        $this->eventUser = $eventUser;

        if( get_class($tokenStorage->getToken() ) == UsernamePasswordToken::class ) { // TODO : checker autrement
            $this->user = $tokenStorage->getToken()->getUser();
        }
    }

    /**
     * @Route("/jeu-de-societe/ajax/{act}/{id}", name="boardgame.join")
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


        $arguments = [
            'events' => $events,
            'active_round' => $round,
        ];

        switch( $act ){
            case 'join' :
                if( $this->eventUser->isEventTimeFree( $event ) && $event->isFreeSlots() ) {

                    $event->addPlayer( $this->user );
                    $this->getDoctrine()->getManager()->flush();

                    return $this->render('envol/block/boardgame-events.html.twig', $arguments );
                }
                break;
            case 'leave' :
                $event->removePlayer( $this->user );
                $this->getDoctrine()->getManager()->flush();

                return $this->render('envol/block/boardgame-events.html.twig', $arguments );
                break;
        }

        return null;
    }

    /**
     * @Route("/jeu-de-societe/editer/{event}", name="boardgame.edit")
     */
    public function edit( Event $event,  Request $request ) {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        /** @var User $current_user */
        $current_user = $this->getUser();

        if(!in_array('ROLE_JDS',$current_user->getRoles() )){
            $exeption = $this->createAccessDeniedException();
            throw $exeption;
        }

        //$round = $this->getRoundFromTimeCode( $time, $rounds );

        $form = $this->createForm( BoardgameEventType::class, $event );

        $form->handleRequest( $request );

        if ( $form->isSubmitted() && $form->isValid() ) {


            $eventType = $this->getDoctrine()->getRepository(EventType::class )->findOneBy( ['name' => self::EVENT_TYPE_NAME] );

            $event
                ->setEventType( $eventType );

            $entityManager = $this->getDoctrine()->getManager();
            //$entityManager->persist( $event );
            $entityManager->flush();

            return $this->redirectToRoute('boardgame', ['time' => $event->getRound()->getCode()]);

        }

        $title = [
            'color' =>  'bd-bleu',
            'pic' => 'images/title/jds.png',
            'name' => 'Jeu de société',
        ];

        return $this->render('envol/pages/boardgame-edit-event.html.twig', [
            'title' => $title,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/jeu-de-societe/ajouter/{time}", name="boardgame.add")
     */
    public function add( $time = false,  Request $request ) {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        /** @var User $current_user */
        $current_user = $this->getUser();

        if(!in_array('ROLE_JDS',$current_user->getRoles() )){
            $exeption = $this->createAccessDeniedException();
            throw $exeption;
        }

        $round = $this->getRoundFromTimeCode( $time, $rounds );

        $event = new Event();
        $event->setRound( $round );

        $form = $this->createForm( BoardgameEventType::class, $event );

        $form->handleRequest( $request );

        if ( $form->isSubmitted() && $form->isValid() ) {


            $eventType = $this->getDoctrine()->getRepository(EventType::class )->findOneBy( ['name' => self::EVENT_TYPE_NAME] );

            $event
                ->setEventType( $eventType );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist( $event );
            $entityManager->flush();

            return $this->redirectToRoute('boardgame', ['time' => $event->getRound()->getCode()]);

        }

        $title = [
            'color' =>  'bd-bleu',
            'pic' => 'images/title/jds.png',
            'name' => 'Jeu de société',
        ];

        return $this->render('envol/pages/boardgame-add-event.html.twig', [
            'title' => $title,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/jeu-de-societe/{time}", name="boardgame")
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
            'color' =>  'bd-bleu',
            'pic' => 'images/title/jds.png',
            'name' => 'Jeu de société',
        ];

        return $this->render('envol/pages/boardgame-list.html.twig', array(
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