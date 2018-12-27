<?php

namespace App\Controller\Old;

use App\Entity\Activity;
use App\Entity\ActivityType;
use App\Entity\Round;
use App\Entity\User;
use App\Form\BoardgameActivityType;
use App\Service\ActivityUser;
use App\Service\TimeZones;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class BoradgameController extends Controller
{

    private $timezones;
    private $activityUser;
    private $user;

    public const ACTIVITY_TYPE_NAME = 'boardgame';

    public function __construct( TimeZones $timeZones, TokenStorageInterface $tokenStorage, ActivityUser $activityUser)
    {
        $this->timezones = $timeZones;
        $this->activityUser = $activityUser;

        if( get_class($tokenStorage->getToken() ) == UsernamePasswordToken::class ) { // TODO : checker autrement
            $this->user = $tokenStorage->getToken()->getUser();
        }
    }

    /**
     * @Route("/jeu-de-societe/ajax/{act}/{id}", name="boardgame.join")
     */
    public function ajax( $act, Activity $activity ) {

        $this->denyAccessUnlessGranted( 'IS_AUTHENTICATED_REMEMBERED' );

        $activityType = $this->getDoctrine()->getRepository(ActivityType::class )->findOneBy( ['name' => self::ACTIVITY_TYPE_NAME] );
        $round = $activity->getRound();
        $activities = $this->getDoctrine()->getRepository(Activity::class )
            ->findBy( [
                'round' => $round,
                'activityType' => $activityType,
            ] );


        $arguments = [
            'activities' => $activities,
            'active_round' => $round,
        ];

        switch( $act ){
            case 'join' :
                if( $this->activityUser->isActivityTimeFree( $activity ) && $activity->isFreeSlots() ) {

                    $activity->addPlayer( $this->user );
                    $this->getDoctrine()->getManager()->flush();

                    return $this->render('envol/block/boardgame-activities.html.twig', $arguments );
                }
                break;
            case 'leave' :
                $activity->removePlayer( $this->user );
                $this->getDoctrine()->getManager()->flush();

                return $this->render('envol/block/boardgame-activities.html.twig', $arguments );
                break;
        }

        return null;
    }

    /**
     * @Route("/jeu-de-societe/editer/{activity}", name="boardgame.edit")
     */
    public function edit( Activity $activity, Request $request ) {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        /** @var User $current_user */
        $current_user = $this->getUser();

        if(!in_array('ROLE_JDS',$current_user->getRoles() )){
            $exeption = $this->createAccessDeniedException();
            throw $exeption;
        }

        //$round = $this->getRoundFromTimeCode( $time, $rounds );

        $form = $this->createForm( BoardgameActivityType::class, $activity );

        $form->handleRequest( $request );

        if ( $form->isSubmitted() && $form->isValid() ) {


            $activityType = $this->getDoctrine()->getRepository(ActivityType::class )->findOneBy( ['name' => self::ACTIVITY_TYPE_NAME] );

            $activity->setType( $activityType );

            $entityManager = $this->getDoctrine()->getManager();
            //$entityManager->persist( $activity );
            $entityManager->flush();

            return $this->redirectToRoute('boardgame', ['time' => $activity->getRound()->getCode()]);

        }

        $title = [
            'color' =>  'bd-bleu',
            'pic' => 'images/title/jds.png',
            'name' => 'Jeu de société',
        ];

        return $this->render('envol/pages/boardgame-edit-activity.html.twig', [
            'title' => $title,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/jeu-de-societe/ajouter/{time}", name="boardgame.add")
     */
    public function add( $time = false,  Request $request ) {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        /** @var User $current_user */
        $current_user = $this->getUser();

        if(!in_array('ROLE_JDS',$current_user->getRoles() )){
            $exeption = $this->createAccessDeniedException();
            throw $exeption;
        }

        $round = $this->getRoundFromTimeCode( $time, $rounds );

        $activity = new Activity();
        $activity->setRound( $round );

        $form = $this->createForm( BoardgameActivityType::class, $activity );

        $form->handleRequest( $request );

        if ( $form->isSubmitted() && $form->isValid() ) {


            $activityType = $this->getDoctrine()->getRepository(ActivityType::class )->findOneBy( ['name' => self::ACTIVITY_TYPE_NAME] );

            $activity
                ->setType( $activityType );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist( $activity );
            $entityManager->flush();

            return $this->redirectToRoute('boardgame', ['time' => $activity->getRound()->getCode()]);

        }

        $title = [
            'color' =>  'bd-bleu',
            'pic' => 'images/title/jds.png',
            'name' => 'Jeu de société',
        ];

        return $this->render('envol/pages/boardgame-add-activity.html.twig', [
            'title' => $title,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/jeu-de-societe/{time}", name="boardgame")
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
            'color' =>  'bd-bleu',
            'pic' => 'images/title/jds.png',
            'name' => 'Jeu de société',
        ];

        return $this->render('envol/pages/boardgame-list.html.twig', array(
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