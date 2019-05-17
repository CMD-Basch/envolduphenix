<?php

namespace App\Controller;

use App\Entity\ActivityType;
use App\Entity\Round;
use App\Service\Event\EventService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class AdvertController extends AbstractController
{

    private $em;
    private $twig;
    private $sEvent;

    public function __construct ( EntityManagerInterface $em, EventService $sEvent, Environment $twig )
    {
        $this->em = $em;
        $this->twig = $twig;
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

        return $this->render( 'envol/advert/round.html.twig', [
            'round' => $round,
        ]);
    }

    /**
     * @Route("/advert/ajax/{round}", name="advert.ajax.round")
     */
    public function advertAjaxRound( Round $round ) {

        $activities = $round->getActivities();
        $blocks = [];
        foreach ( $activities as $index => $activity ){
            $block = $this->twig->render('envol/pages/activity/roleplay/block/activity.block.html.twig', [
                'activity' => $activity,
                'buttons' => false,
                'index' => $index,
            ]);

            $blocks[] = [
                'html' => $block,
                'id' => $activity->getId(),
            ];
        }

        return new JsonResponse([
            'status' => 'ok',
            'blocks' => $blocks
        ]);
    }



}
