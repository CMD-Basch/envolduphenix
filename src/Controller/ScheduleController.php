<?php

namespace App\Controller;
use App\Entity\Event;
use App\Entity\View;
use App\Service\EventUser;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ScheduleController extends Controller
{

    private $user;
    private $eventUser;

    public function __construct( TokenStorageInterface $tokenStorage, EventUser $eventUser)
    {
        $this->eventUser = $eventUser;
        if( get_class($tokenStorage->getToken() ) == UsernamePasswordToken::class ) { // TODO : checker autrement
            $this->user = $tokenStorage->getToken()->getUser();
        }
    }


    /**
     * @Route("/profil/emploi-du-temps", name="schedule")
     */
    public function home() {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $events = $this->eventUser->getEvents();

        $title = [
            'color' => 'bd-orange',
            'pic' => 'images/title/blk.png',
            'name' => 'Emploi du temps',
        ];

        return $this->render('envol/pages/schedule-home.html.twig', [
                'title' => $title,
                'events' => $events,
            ]);
    }

}