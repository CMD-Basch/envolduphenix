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
    private $timezones;

    public function __construct( EntityManagerInterface $em, TokenStorageInterface $tokenStorage, TimeZones $timezones )
    {
        $this->em = $em;
        $this->timezones = $timezones;

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

    /**
     * @return Event[]
     */
    public function getEvents() {
        if( !isset( $this->events ) ){
            $this->loadEvents();
        }
        return $this->events;
    }

    /**
     * @param Round $round
     * @return bool
     */
    public function isRoundTimeFree( Round $round ) {
        return $this->isFreeTime( $round->getStart(), $round->getEnd() );
    }

    /**
     * @param Event $event
     * @return bool
     */
    public function isEventTimeFree( Event $event ) {
        return $this->isFreeTime( $event->getStart(), $event->getEnd() );
    }

    /**
     * @param $start
     * @param $end
     * @return bool
     */
    private function isFreeTime( $start, $end ) { // TODO : a reecrire avec ->getEvents();
        $events = $this->em->getRepository(Event::class )->findAll();
        foreach( $events as $event ){
            if( $event->getMaster() == $this->user || $event->isPlayer( $this->user )) {
                if ($event->getStart() < $end && $event->getEnd() > $start) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * @param $hour
     * @return Event|false
     */
    public function getEventStartAt( $hour, $day ){
        $events = $this->getEvents();
        foreach ( $events as $event ){
            dump($event->getStart()->format('G') . ' == ' . $hour . ' : ' . ($event->getStart()->format('G') == $hour));
            if ( $event->getStart()->format('G') == $hour && $this->timezones->isInDay( $event , $day )){
                return $event;
            }
        }
        return false;
    }

}