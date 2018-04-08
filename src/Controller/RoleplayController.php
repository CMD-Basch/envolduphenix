<?php

namespace App\Controller;
use App\Entity\View;
use App\Service\TimeZones;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RoleplayController extends Controller
{

    private $timezones;

    public function __construct( TimeZones $timeZones )
    {
        $this->timezones = $timeZones;
    }

    /**
     * @Route("/jeu-de-roles/test", name="roleplay.add")
     */
    public function date(  ) {

        $title = [
            'color' =>  'bd-orange',
            'pic' => 'images/title/jdr.png',
            'name' => 'Jeu de rôle',
        ];

        $page = 'YOLO';

        $title['pic'] = 'images/title/'.$title['pic'].'.png';

        return $this->render('envol/standard.html.twig', array(
            'title' => $title,
            'page' => $page,
        ));

    }

    /**
     * @Route("/jeu-de-roles/{time}", name="roleplay")
     */
    public function home( $time = false ) {

        if( !$this->timezones->checkTimeCode( $time ) ) {
            $time = key( $this->timezones->getAll() );
        }

        $title = [
            'color' =>  'bd-orange',
            'pic' => 'images/title/jdr.png',
            'name' => 'Jeu de rôle',
        ];

        return $this->render('envol/pages/roleplay-list.html.twig', array(
            'title' => $title,
            'active_tab' => $time,
        ));
    }
}