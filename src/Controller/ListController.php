<?php

namespace App\Controller;
use App\Entity\Parrainer;
use App\Entity\Round;
use App\Entity\User;
use App\Entity\View;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ListController extends Controller
{

    /**
     * @Route("/show/{id}", name="listeprojo")
     */
    public function textView( Round $round ) {

        return $this->render('screen/roleplay-event-list.html.twig', [
            'round' => $round
        ]);

    }


    /**
     * @Route("/all_stats", name="all_stats")
     */
    public function stats () {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        /** @var User $current_user */
        $current_user = $this->getUser();

        if(!in_array('ROLE_ADMIN',$current_user->getRoles() )){
            $exeption = $this->createAccessDeniedException();
            throw $exeption;
        }

        $lines = ['STATS',''];

        $users = $this->getDoctrine()->getRepository(User::class )->findAll();


        $nb_player = 0;
        $nb_master = 0;
        $nb_total  = 0;

        foreach( $users as $user ){

            $bool_player = false;
            $bool_master = false;

            foreach ( $user->getEvents() as $event ) {
                if( $event->getEventType()->getName() == 'roleplay' ){
                    $bool_player = true;
                    break;
                }
            }
            if( count($user->getMasteredEvents()) > 0 ) {
                $bool_master = true;
            }
            if( $bool_player ){
                $nb_player++;
            }
            if( $bool_master ){
                $nb_master++;
            }
            if( $bool_master || $bool_player ){
                $nb_total++;
            }

        }

        $lines[] = 'Nombre Joueurs : '.$nb_player;
        $lines[] = 'Nombre Meneurs : '.$nb_master;
        $lines[] = 'Nombre Total : '.$nb_total;


        return $this->render('raw/stats.html.twig', [
            'lines' => $lines
        ]);

    }
}