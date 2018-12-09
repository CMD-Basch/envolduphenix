<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\ActivityType;
use App\Entity\Round;
use App\Form\RoleplayActivityType;
use App\Service\ActivityUser;
use App\Service\TimeZones;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class ActivityController extends Controller
{

    private $timezones;
    private $activityUser;
    private $user;

    public function __construct( TimeZones $timeZones, TokenStorageInterface $tokenStorage, ActivityUser $activityUser)
    {
        $this->timezones = $timeZones;
        $this->activityUser = $activityUser;

        if( get_class($tokenStorage->getToken() ) == UsernamePasswordToken::class ) { // TODO : checker autrement
            $this->user = $tokenStorage->getToken()->getUser();
        }
    }

    /**
     * @Route("/activite/ajax/{act}/{id}", name="activity.join")
     */
    public function ajax( $act, Activity $activity ) {

        $this->denyAccessUnlessGranted( 'IS_AUTHENTICATED_REMEMBERED' );

        switch( $act ){
            case 'join' :
                if( $this->activityUser->isActivityTimeFree( $activity ) && $activity->isFreeSlots() ) {

                    $activity->addPlayer( $this->user );
                    $this->getDoctrine()->getManager()->flush();

                    //return $this->render( 'roleplay-activities.html.twig', $arguments );
                }
                break;
            case 'leave' :
                $activity->removePlayer( $this->user );
                $this->getDoctrine()->getManager()->flush();

                //return $this->render( 'roleplay-activities.html.twig', $arguments );
                break;
        }

        //return $this->render( 'roleplay-activities.html.twig', $arguments );
    }

    /**
     * @Route("/activite/ajouter/{type}", name="activity.add")
     */
    public function add( $type ,  Request $request ) {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $round = $this->getRoundFromTimeCode( $time, $rounds );

        $activity = new Activity();
        $activity->setRound( $round );

        $form = $this->createForm( RoleplayActivityType::class, $activity );

        $form->handleRequest( $request );
        if ( $form->isSubmitted() && $form->isValid() ) {

            if( $this->activityUser->isRoundTimeFree( $round ) ) {
                $activityType = $this->getDoctrine()->getRepository(ActivityType::class )->findOneBy( ['name' => self::ACTIVITY_TYPE_NAME] );

                $activity
                    ->setActivityType( $activityType )
                    ->setMaster( $this->getUser() );

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist( $activity );
                $entityManager->flush();

                return $this->redirectToRoute('roleplay', ['time' => $activity->getRound()->getCode()]);
            }
        }

        $title = [
            'color' =>  'bd-orange',
            'pic' => 'images/title/jdr.png',
            'name' => 'Jeu de rôle',
        ];

        return $this->render('envol/pages/roleplay-add-activity.html.twig', [
            'title' => $title,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/activite/{time}", name="activity.time")
     */
    public function home( $time = false ) {

        $round = $this->getRoundFromTimeCode( $time, $rounds );
        $activityType = $this->getDoctrine()->getRepository( ActivityType::class )->findOneBy( ['name' => self::ACTIVITY_TYPE_NAME] );

        $activities = $this->getDoctrine()->getRepository(Activity::class )
            ->findBy( [
                'round' => $round,
                'activityType' => $activityType,
                ] );

        $title = [
            'color' =>  'bd-orange',
            'pic' => 'images/title/jdr.png',
            'name' => 'Jeu de rôle',
        ];

        return $this->render('envol/pages/roleplay-list.html.twig', array(
            'title' => $title,
            'active_round' => $round,
            'rounds' => $rounds,
            'activities' => $activities,
        ));
    }

    private function getRoundFromTimeCode( &$time, &$rounds ) {

        $rounds = $this->timezones->getByActivityName( self::ACTIVITY_TYPE_NAME );

        if( !$this->timezones->checkTimeCode( $time ) ) {
            $time = key( $rounds );
        }

        return $this->getDoctrine()->getRepository( Round::class )->findOneBy( ['code' => $time] );

    }
}