<?php

namespace App\Service;


use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;

class SiteGlobals
{

    private $em;

    public function __construct( EntityManagerInterface $em )
    {
        $this->em = $em;
    }

    /**
     * @return Event[]
     */
    public function getEventsToCome(): array {
        return $this->em->getRepository( Event::class )->findToCome( new \DateTime() );
    }

    public function isEventToCome(): bool {
        return !empty( $this->getEventsToCome() );
    }

    public function getNextEvent(): ?Event {
        return current( $this->getEventsToCome() );
    }
}