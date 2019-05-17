<?php

namespace App\Controller;

use App\Entity\ActivityType;
use App\Entity\Round;
use App\Service\Event\EventService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdvertController extends AbstractController
{

    private $em;
    private $sEvent;

    public function __construct ( EntityManagerInterface $em, EventService $sEvent )
    {
        $this->em = $em;
        $this->sEvent = $sEvent;
    }

    /**
     * @Route("/advert", name="advert")
     */
    public function advert( ) {

        $type = $this->em->getRepository( ActivityType::class )->findOneBy(['slug' => 'jeu-de-roles']);
        $rounds = $this->em->getRepository( Round::class )->findBy(['activityType' => $type]);

        return $this->render( 'envol/advert/round-list.html.twig', [
            'rounds' => $rounds,
        ]);
    }

    /**
     * @Route("/advert/{round}", name="advert.round")
     */
    public function advertRound( Round $round ) {

        dump( $round->getActivities()->toArray() );


//        $type = $this->em->getRepository( ActivityType::class )->findOneBy(['slug' => 'jeu-de-roles']);
//        $rounds = $this->em->getRepository( Round::class )->findBy(['activityType' => $type]);

        return $this->render( 'envol/advert/round.html.twig', [
            'round' => $round,
        ]);
    }

}
