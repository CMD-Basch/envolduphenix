<?php

namespace App\Service;


use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\Round;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class TimeZones
{
    private $em;
    private $user;



    public function __construct( EntityManagerInterface $em, TokenStorageInterface $tokenStorage )
    {
        $this->em = $em;

        if( get_class($tokenStorage->getToken() ) == UsernamePasswordToken::class ) { // TODO : checker autrement
            $this->user = $tokenStorage->getToken()->getUser();
        }

    }

    public function getAll()
    {
        return $this->formatId( $this->em->getRepository(Round::class )->findAll() );
    }

    public function getByEventName( $eventType )
    {
        $id = $this->em->getRepository(EventType::class )->findOneBy( ['name' => $eventType] );
        $return = $this->em->getRepository(Round::class )->findBy( ['eventType' => $id] );
        $return = $this->formatId( $return );
        return $return;
    }

    public function checkTimeCode( $code, $eventType = false )
    {
        if ( $code ) {
            if ( $eventType ) {
                return array_key_exists( $code, $this->getByEventName( $eventType ) );
            } else {
                return array_key_exists( $code, $this->getAll() );
            }
        }

        return false;
    }

    private function formatId( $rounds ) {
        $output = [];
        /** @var Round $round */
        foreach ( $rounds as $round ) {
            if( get_class( $round ) == Round::class ) {
                $output[ $round->getCode() ] = $round;
            }
        }
        return $output;
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

    private function isFreeTime( $start, $end ) {
        $events = $this->em->getRepository(Event::class )->findAll();
        foreach( $events as $event ){
            dump($event);
            if( $event->getMaster() == $this->user || $event->isPlayer( $this->user )) {
                if ($event->getFinalStart() < $end && $event->getFinalEnd() > $start) {
                    return false;
                }
            }
        }
        return true;
    }

}