<?php

namespace App\Controller;

use App\Entity\Event;
use App\Service\EventButton;
use App\Service\EventUser;

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
    private $eventUser;
    private $eventButton;


    public function __construct( EntityManagerInterface $em, TokenStorageInterface $tokenStorage, EventUser $eventUser, EventButton $eventButton)
    {
        $this->em = $em;
        $this->eventUser = $eventUser;
        $this->eventButton = $eventButton;


        if( get_class($tokenStorage->getToken() ) == UsernamePasswordToken::class ) { // TODO : checker autrement
            $this->user = $tokenStorage->getToken()->getUser();
        }
    }


    /**
     * @Route("/emploi-du-temps", name="schedule")
     */
    public function home() {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $events = $this->eventUser->getEvents();

        $title = [
            'color' => 'bd-bleu',
            'pic' => 'images/title/blk.png',
            'name' => 'Mon profil',
        ];

        return $this->render('envol/pages/schedule-home.html.twig', [
                'title' => $title,
                'events' => $events,
            ]);
    }

    /**
     * @Route("/ajax/link/{act}/{tag}", name="act.link")
     */
    public function act( $act, $tag ) {
        /** @var Event $event */
        $event = $this->em->getRepository( Event::class )->findBy( ['tag' => $tag] )[0];
        dump($act);
        switch ( $act ){
            case 'join' :
                if( $this->eventUser->isEventTimeFree( $event ) ){
                    $event->addPlayer( $this->user );
                }
                break;
            case 'leave' :
                dump($event->isPlayer( $this->user ));
                if( $event->isPlayer( $this->user ) ){
                    $event->removePlayer( $this->user );
                }
                break;
        }
        $this->em->flush();
        return new Response( $this->eventButton->print( $tag ) );
    }


}