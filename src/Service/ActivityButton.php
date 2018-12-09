<?php

namespace App\Service;


use App\Entity\Activity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class ActivityButton
{
    private $em;
    private $user;
    private $timezones;
    private $activityUser;

    public function __construct( EntityManagerInterface $em, TokenStorageInterface $tokenStorage, TimeZones $timezones, ActivityUser $activityUser )
    {
        $this->em = $em;
        $this->timezones = $timezones;
        $this->activityUser = $activityUser;

        $this->user = false;
        if( get_class($tokenStorage->getToken() ) == UsernamePasswordToken::class ) { // TODO : checker autrement
            $this->user = $tokenStorage->getToken()->getUser();
        }

    }

    public function print( $activity_tag ) {

        $activity = $this->em->getRepository( Activity::class )->findBy( ['tag' => $activity_tag] )[0];

        if( !$activity ) {
            return 'NOPE';
        }

        if( $this->user ) {
            if ($activity->isPlayer($this->user)) {
                $button = '<span id="link-' . $activity_tag . '"><a href="#" role="button" data-act="leave" data-id="' . $activity_tag . '" class="ajax-link btn btn-primary">Quitter l\'activité ' . $activity->getName() . '</a></span>';
            } else if ( !$activity->isFreeSlots() ) {
                $button = '<span id="link-' . $activity_tag . '"><a href="#" role="button" tabindex="-1" aria-disabled="true"  class="btn btn-secondary disabled">' . $activity->getName() . ' complet</a></span>';
            } else if ($this->activityUser->isActivityTimeFree($activity)) {
                $button = '<span id="link-' . $activity_tag . '"><a href="#" role="button" data-act="join" data-id="' . $activity_tag . '" class="ajax-link btn btn-primary">S\'inscrire à ' . $activity->getName() . '</a></span>';
            } else {
                $button = '<span id="link-' . $activity_tag . '"><a href="#" class="btn btn-secondary btn-lg disabled" tabindex="-1" role="button" aria-disabled="true">Vous avez une autre activité à ce moment là</a></span>';
            }

        }
        else {
            $button = '<span id="link-' . $activity_tag . '"><a href="#" class="btn btn-secondary btn-lg disabled" tabindex="-1" role="button" aria-disabled="true">Vous devez être connecté pour pouvoir vous inscrire</a></span>';
        }

        return $button;
    }

}