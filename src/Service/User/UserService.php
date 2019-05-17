<?php

namespace App\Service\User;


use App\Entity\Activity;
use App\Entity\Booking;
use App\Entity\Round;
use App\Entity\User;
use App\Service\Event\EventService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserService
{
    /** @var User|object|string  */
    private $user;
    private $tokenStorage;

    private $sEvent;

    public function __construct( TokenStorageInterface $token, EventService $sEvent )
    {
        $this->tokenStorage = $token;
        $this->sEvent = $sEvent;
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

    public function isBookOnNextOpenEvent(): ?bool {

        $event = $this->sEvent->getNextOpenEvent();
        if(!$event) return null;

        /** @var Booking $lastBook */
        $lastBook = $this->getUser()->getBookings()->filter( function ( Booking $b ) use ( $event ) {
           return $b->getEvent() === $event;
        })->first();

        if(!$lastBook) return false;
//dump($lastBook);
        return $lastBook->getBooked();

    }

    public function getOverlapActivities( \DateTimeInterface $start, \DateTimeInterface $end ): Collection {
        if(!$user = $this->getUser()) return new ArrayCollection();
        $activities = $user->getAllActivities();
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

    public function getActivitiesForDay( \DateTime $day ){
        return $this->getUser()->getAllActivities()->filter( function ( Activity $a ) use ( $day ) {
            return $day->format('z') == $a->getStart()->format('z') ||
                $day->format('z') == $a->getEnd()->format('z');
        });
    }

    public function getActivitiesForDayAndHour( \DateTime $day, int $hour ){
        return $this->getUser()->getAllActivities()->filter( function ( Activity $a ) use ( $day, $hour ) {
            return $day->format('z') == $a->getStart()->format('z') && $day->format('h') == $hour;
        });
    }
}
