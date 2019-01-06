<?php

namespace App\Service\User;


use App\Entity\Activity;
use App\Entity\Round;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserService
{
    /** @var User|object|string  */
    private $user;
    private $tokenStorage;

    public function __construct( TokenStorageInterface $token )
    {
        $this->tokenStorage = $token;
    }

    public function getUser(): ?User {

        if( !isset( $this->user ) ){
            $this->user = $this->tokenStorage->getToken()->getUser();
        }

        if( $this->user instanceof User ){
            return $this->user;
        }
        return null;
    }

    public function getOverlapActivities( \DateTimeInterface $start, \DateTimeInterface $end ): Collection {
        $activities = $this->getUser()->getAllActivities();
        $overlap = new ArrayCollection();

        foreach ( $activities as $activity ){
            if( $activity->getStart() < $end
            && $activity->getEnd() > $start ){
                $overlap->add( $activity );
            }


        }

        return $overlap;
    }

    public function isFreeTimeActivity(Activity $activity ): bool {
        return $this->getOverlapActivities( $activity->getStart(), $activity->getEnd() )->count() == 0;
    }

    public function isFreeTimeRound(Round $round ): bool {
        return $this->getOverlapActivities( $round->getStart(), $round->getEnd() )->count() == 0;
    }

    public function canJoin( Activity $activity ): bool {
        if( !$this->isFreeTimeActivity( $activity ) ) return false;
        if( $activity->isPlayer( $this->getUser() ) ) return false;
        if( $activity->isMaster( $this->getUser() ) ) return false;
        return true;
    }

    public function canLeave( Activity $activity ): bool {
        if( $activity->isPlayer( $this->getUser() ) ) return true;
        return false;
    }
}