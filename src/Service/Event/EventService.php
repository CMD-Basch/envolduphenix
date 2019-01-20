<?php

namespace App\Service\Event;


use App\Entity\Activity;
use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;

class EventService
{

    private $em;

    private $week;

    public function __construct( EntityManagerInterface $em )
    {
        $this->em = $em;
    }

    public function getTheEvent(): ?Event {
        return $this->em->getRepository( Event::class )->findOneBy(['active' => true], ['start' => 'DESC']);
    }

    /**
     * @return \DateTime[]
     */
    public function getDays( Event $event ): array {
        if( !isset($this->week) ){
            $start =  new \DateTime( $event->getStart()->format('m/d/y'));
            $end =  new \DateTime( $event->getEnd()->format('m/d/y'));
            $interval = new \DateInterval('P0000-00-01T00:00:00');

            $this->week = [];

            for( ; $start <= $end; $start->add( $interval ) ){
                $this->week[] = clone $start;
            }
        }

        return $this->week;
    }

    public function getActivitiesForDay( \DateTime $day ){
        return $this->getTheEvent()->getActivities()->filter( function ( Activity $a ) use ( $day ) {
            return $day->format('z') == $a->getStart()->format('z');
        });
    }

    public function getNextOpenEvent(): ?Event {
        $event = $this->getTheEvent();
        $now  = new \DateTime();
        if( $event->getStart() < $now ) return null;
        if( !$event->getOpen() ) return null;

        return $event;
    }

}