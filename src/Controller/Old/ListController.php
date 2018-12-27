<?php

namespace App\Controller\Old;
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

        return $this->render( 'roleplay-activity-list.html.twig', [
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


        $stats['rpg_player'] = 0;
        $stats['rpg_master'] = 0;
        $stats['rpg_total']  = 0;

        $stats['murder_player'] = 0;

        foreach( $users as $user ){

            $bool_player = false;
            $bool_master = false;

            foreach ( $user->getActivities() as $activity ) {
                if( $activity->getType()->getName() == 'roleplay' ) {
                    $bool_player = true;
                }
                if( $activity->getType()->getName() == 'murder' ) {
                    $stats['murder_player']++;
                }
            }
            if( count($user->getMasteredActivities()) > 0 ) {
                $bool_master = true;
            }
            if( $bool_player ){
                $stats['rpg_player']++;
            }
            if( $bool_master ){
                $stats['rpg_master']++;
            }
            if( $bool_master || $bool_player ){
                $stats['rpg_total']++;
            }

        }


        $lines[] = '### JEU DE ROLE ###';
        $lines[] = 'Nombre Joueurs : ' . $stats['rpg_player'];
        $lines[] = 'Nombre Meneurs : ' . $stats['rpg_master'];
        $lines[] = 'Nombre Total : ' . $stats['rpg_total'];

        $lines[] = '';
        $lines[] = '### MURDER PARTY ###';
        $lines[] = 'Nombre Joueurs : ' . $stats['murder_player'];


        return $this->render('raw/stats.html.twig', [
            'lines' => $lines
        ]);

    }
}