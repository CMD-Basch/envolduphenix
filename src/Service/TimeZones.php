<?php

namespace App\Service;


use App\Entity\EventType;
use App\Entity\Round;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class TimeZones
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAll()
    {
        return $this->formatId( $this->em->getRepository(Round::class)->findAll() );
    }

    public function getByEventName( $eventType )
    {
        $id = $this->em->getRepository(EventType::class)->findOneBy( ['name' => $eventType] );
        $return = $this->em->getRepository(Round::class)->findBy( ['eventType' => $id] );
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

}