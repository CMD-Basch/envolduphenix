<?php

namespace App\Service;


use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class EventButton
{
    private $em;
    private $user;
    private $events;
    private $timezones;
    private $eventUser;

    public function __construct( EntityManagerInterface $em, TokenStorageInterface $tokenStorage, TimeZones $timezones, EventUser $eventUser )
    {
        $this->em = $em;
        $this->timezones = $timezones;
        $this->eventUser = $eventUser;

        $this->user = false;
        if( get_class($tokenStorage->getToken() ) == UsernamePasswordToken::class ) { // TODO : checker autrement
            $this->user = $tokenStorage->getToken()->getUser();
        }

    }

    public function print( $event_tag ) {

        /** @var Event $event */
        $event = $this->em->getRepository( Event::class )->findBy( ['tag' => $event_tag] )[0];

        if( !$event ) {
            return 'NOPE';
        }

        if( $this->user ) {
            if ($event->isPlayer($this->user)) {
                $button = '<span id="link-' . $event_tag . '"><a href="#" role="button" data-act="leave" data-id="' . $event_tag . '" class="ajax-link btn btn-primary">Quitter l\'activité ' . $event->getName() . '</a></span>';
            } else if ( !$event->isFreeSlots() ) {
                $button = '<span id="link-' . $event_tag . '"><a href="#" role="button" tabindex="-1" aria-disabled="true"  class="btn btn-secondary disabled">' . $event->getName() . ' complet</a></span>';
            } else if ($this->eventUser->isEventTimeFree($event)) {
                $button = '<span id="link-' . $event_tag . '"><a href="#" role="button" data-act="join" data-id="' . $event_tag . '" class="ajax-link btn btn-primary">S\'inscrire à ' . $event->getName() . '</a></span>';
            } else {
                $button = '<span id="link-' . $event_tag . '"><a href="#" class="btn btn-secondary btn-lg disabled" tabindex="-1" role="button" aria-disabled="true">Vous avez une autre activité à ce moment là</a></span>';
            }

        }
        else {
            $button = '<span id="link-' . $event_tag . '"><a href="#" class="btn btn-secondary btn-lg disabled" tabindex="-1" role="button" aria-disabled="true">Vous devez être connecté pour pouvoir vous inscrire</a></span>';
        }

        return $button;
    }

}