<?php

namespace App\Service;


use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\Round;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class TimeZones
{
    private $em;
    private $user;
    private $days;
    private $day;



    public function __construct( EntityManagerInterface $em, TokenStorageInterface $tokenStorage )
    {
        $this->em = $em;

        if( get_class($tokenStorage->getToken() ) == UsernamePasswordToken::class ) { // TODO : checker autrement
            $this->user = $tokenStorage->getToken()->getUser();
        }

        $this->days =  [
            1 => [
                'start' => \DateTime::createFromFormat("d/m/Y H","11/05/2018 5"),
                'end' => \DateTime::createFromFormat("d/m/Y H","12/05/2018 4"),
            ],
            2 => [
                'start' => \DateTime::createFromFormat("d/m/Y H","12/05/2018 5"),
                'end' => \DateTime::createFromFormat("d/m/Y H","13/05/2018 4"),
            ],
            3 => [
                'start' => \DateTime::createFromFormat("d/m/Y H","13/05/2018 5"),
                'end' => \DateTime::createFromFormat("d/m/Y H","14/05/2018 4"),
            ],
        ];

        $this->day = [ '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '1', '2', '3', '4'];

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

    public function getDay() {
        return $this->day;
    }
    public function getDayName( $day ){
        switch( $day ){
            case '1' : return 'Vendredi' ;
            case '2' : return 'Samedi' ;
            case '3' : return 'Dimanche' ;
            default  : return ' ?? ';
        }
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

    public function countDays() {

        return 3;
    }

    public function isInDay( Event $event, $dayNbr ) {

        $day = $this->days[ $dayNbr ];

        if( $event->getEnd() > $day['start']  && $event->getStart() < $day['end'] ) {
           return true;
        }
        return false;
    }



}