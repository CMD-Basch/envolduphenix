<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\ActivityType;
use App\Model\ModuleInterface;
use App\Service\Event\EventService;
use App\Service\Module\ModuleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ActivityController extends AbstractController
{
    private $sEvent;
    private $sModule;

    private $twig;

    private $theEvent;

    public function __construct( EventService $sEvent, ModuleService $sModule, Environment $twig )
    {
        $this->sEvent = $sEvent;
        $this->sModule = $sModule;
        $this->twig = $twig;
        $this->theEvent = $sEvent->getTheEvent();
    }


    /**
     * @Route("/activites/{slug}/liste", name="activity.module.list")
     */
    public function listActionModule(ActivityType $activityType) {

        $module = $this->sModule->load( $activityType );
        if( !$module ) return $this->redirectToRoute( 'home');

        return $this->render( $this->loadTemplate( 'list.html.twig', $module ), [
            'event' => $this->theEvent,
            'activities' => $module->getList(),
        ]);
    }

    /**
     * @Route("/activites/{slug}/nouveau", name="activity.module.new")
     */
    public function newActionModule(ActivityType $activityType, Request $request) {

        $module = $this->sModule->load( $activityType );
        if( !$module ) return $this->redirectToRoute( 'home');

        $form = $module->getForm();
        $form->handleRequest( $request );
        if ( $form->isSubmitted() && $form->isValid() ) {
            $module->preSubmit( $request );
            $module->submit();
            return $this->redirectToRoute('activity.module.list', ['slug' => $activityType->getSlug() ] );
        }

        return $this->render($this->loadTemplate( 'new.html.twig', $module ), [
            'event' => $this->theEvent,
            'form' => $form->createView(),
        ]);
    }


    private function loadTemplate( string $name, ModuleInterface $module ):string {
        $path = 'envol/pages/activity/';
        $stdModulePath = $path . 'default/' . $name;
        $tplModulePath = $path . $module->getSlug(). '/' . $name;
        if ( $this->twig->getLoader()->exists( $tplModulePath ) ){
            return $tplModulePath;
        }
        return $stdModulePath;
    }


}