<?php

namespace App\Service\Event;


use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;

class EventService
{

    private $em;

    public function __construct( EntityManagerInterface $em )
    {
        $this->em = $em;
    }

    public function getTheEvent(): ?Event {
        return $this->em->getRepository( Event::class )->findOneBy(['active' => true], ['start' => 'DESC']);
    }
}