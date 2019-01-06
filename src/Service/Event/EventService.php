<?php

namespace App\Service\Event;


use App\Entity\Event;
use App\Service\Date\DateFrService;
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

    public function getNextOpenEvent(): ?Event {
        $event = $this->em->getRepository( Event::class )->findOneBy(['active' => true], ['start' => 'DESC']);
        if( $event->getStart() > new \DateTime() ){
            return $event;
        }
        return null;
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

}