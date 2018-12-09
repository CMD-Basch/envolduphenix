<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Service\ActivityButton;
use App\Service\ActivityUser;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ScheduleController extends Controller
{

    private $em;
    private $user;
    private $activityUser;
    private $activityButton;


    public function __construct( EntityManagerInterface $em, TokenStorageInterface $tokenStorage, ActivityUser $activityUser, ActivityButton $activityButton)
    {
        $this->em = $em;
        $this->activityUser = $activityUser;
        $this->activityButton = $activityButton;


        if( get_class($tokenStorage->getToken() ) == UsernamePasswordToken::class ) { // TODO : checker autrement
            $this->user = $tokenStorage->getToken()->getUser();
        }
    }


    /**
     * @Route("/profil/emploi-du-temps", name="schedule")
     */
    public function home() {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $activities = $this->activityUser->getActivities();

        $title = [
            'color' => 'bd-bleu',
            'pic' => 'images/title/blk.png',
            'name' => 'Mon profil',
        ];

        return $this->render('envol/pages/schedule-home.html.twig', [
                'title' => $title,
                'activities' => $activities,
            ]);
    }

    /**
     * @Route("/ajax/link/{act}/{tag}", name="act.link")
     */
    public function act( $act, $tag ) {

        $activity = $this->em->getRepository( Activity::class )->findBy( ['tag' => $tag] )[0];

        switch ( $act ){
            case 'join' :
                if( $this->activityUser->isActivityTimeFree( $activity ) ){
                    $activity->addPlayer( $this->user );
                }
                break;
            case 'leave' :

                if( $activity->isPlayer( $this->user ) ){
                    $activity->removePlayer( $this->user );
                }
                break;
        }
        $this->em->flush();
        return new Response( $this->activityButton->print( $tag ) );
    }


}