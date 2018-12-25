<?php

namespace App\Service;


use App\Entity\Activity;
use App\Entity\ActivityType;
use App\Entity\Round;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class ActivityUser
{

    private $em;
    private $user;
    private $activities;
    private $timezones;

    public function __construct( EntityManagerInterface $em, TokenStorageInterface $tokenStorage, TimeZones $timezones )
    {
        $this->em = $em;
        $this->timezones = $timezones;

//        if( get_class($tokenStorage->getToken() ) == UsernamePasswordToken::class ) { // TODO : checker autrement
//            $this->user = $tokenStorage->getToken()->getUser();
//        }

    }

    public function getFreeRounds( $activityType = false ) {
        if ( $activityType ) {
            $activityType = $this->em->getRepository(ActivityType::class )->findOneBy( ['name' => $activityType] );

            $rounds = $this->em->getRepository(Round::class )->findBy( ['activityType' => $activityType] );
        } else {
            $rounds = $this->em->getRepository(Round::class )->findAll();
        }

        $output = [];
        foreach( $rounds as $round ){
            if( $this->isFreeTime( $round->getStart(), $round->getEnd() ) )
                $output[] = $round;
        }

        return $output;
    }

    private function loadActivities() {
        $activities = $this->em->getRepository( Activity::class )->findAll();
        $array = [];
        foreach( $activities as $activity ){
            if( $activity->isUser( $this->user ) ){
                $array[] = $activity;
            }
        }
        $this->activities = $array;
    }

    /**
     * @return Activity[]
     */
    public function getActivities() {
        if( !isset( $this->activities ) ){
            $this->loadActivities();
        }
        return $this->activities;
    }

    /**
     * @param Round $round
     * @return bool
     */
    public function isRoundTimeFree( Round $round ) {
        return $this->isFreeTime( $round->getStart(), $round->getEnd() );
    }

    /**
     * @param Activity $activity
     * @return bool
     */
    public function isActivityTimeFree( Activity $activity ) {
        return $this->isFreeTime( $activity->getStart(), $activity->getEnd() );
    }

    /**
     * @param $start
     * @param $end
     * @return bool
     */
    private function isFreeTime( $start, $end ) { // TODO : a reecrire avec $user->getActivities();
        $activities = $this->em->getRepository(Activity::class )->findAll();
        foreach( $activities as $activity ){
            if( $activity->getMaster() == $this->user || $activity->isPlayer( $this->user )) {
                if ($activity->getStart() < $end && $activity->getEnd() > $start) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * @param $hour
     * @return Activity|false
     */
    public function getActivityStartAt( $hour, $day ){
        $activities = $this->getActivities();
        foreach ( $activities as $activity ){
            //dump($activity->getStart()->format('G') . ' == ' . $hour . ' : ' . ($activity->getStart()->format('G') == $hour));
            if ( $activity->getStart()->format('G') == $hour && $this->timezones->isInDay( $activity , $day )){
                return $activity;
            }
        }
        return false;
    }

}