<?php

namespace App\Service;


use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\Round;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class EventUser
{

    private $em;
    private $user;
    private $events;

    public function __construct( EntityManagerInterface $em, TokenStorageInterface $tokenStorage )
    {
        $this->em = $em;

        if( get_class($tokenStorage->getToken() ) == UsernamePasswordToken::class ) { // TODO : checker autrement
            $this->user = $tokenStorage->getToken()->getUser();
        }

    }

    public function getFreeRounds( $eventType = false ) {
        if ( $eventType ) {
            $id = $this->em->getRepository(EventType::class )->findOneBy( ['name' => $eventType] );

            $rounds = $this->em->getRepository(Round::class )->findBy( ['eventType' => $id] );
        } else {
            $rounds = $this->em->getRepository(Round::class )->findAll();
        }

        $output = [];
        foreach( $rounds as $round ){
            if( $this->isFreeTime( $round->getStart(), $round->getEnd() ) )
                $output[] = $round;
        }

        return $output;
    }

    private function loadEvents() {
        $allEvents = $this->em->getRepository( Event::class )->findAll();
        $events = [];
        foreach( $allEvents as $event ){
            if( $event->isUser( $this->user ) ){
                $events[] = $event;
            }
        }
        $this->events = $events;
    }

    public function getEvents() {
        if( !isset( $this->events ) ){
            $this->loadEvents();
        }
        return $this->events;
    }

    public function isRoundTimeFree( Round $round ) {
        return $this->isFreeTime( $round->getStart(), $round->getEnd() );
    }

    public function isEventTimeFree( Event $event ) {
        return $this->isFreeTime( $event->getFinalStart(), $event->getFinalEnd() );
    }

    private function isFreeTime( $start, $end ) {
        $events = $this->em->getRepository(Event::class )->findAll();
        foreach( $events as $event ){
            if( $event->getMaster() == $this->user || $event->isPlayer( $this->user )) {
                if ($event->getFinalStart() < $end && $event->getFinalEnd() > $start) {
                    return false;
                }
            }
        }
        return true;
    }

}