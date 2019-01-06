<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\ActivityType;
use App\Model\ModuleInterface;
use App\Service\Event\EventService;
use App\Service\Module\ModuleService;
use App\Service\User\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ActivityController extends AbstractController
{
    private $sEvent;
    private $sModule;
    private $sUser;

    private $twig;

    private $theEvent;

    public function __construct( EventService $sEvent, ModuleService $sModule, UserService $sUser, Environment $twig )
    {
        $this->sEvent = $sEvent;
        $this->sModule = $sModule;
        $this->sUser = $sUser;

        $this->twig = $twig;
        $this->theEvent = $sEvent->getTheEvent();
    }

    private function fetchArguments( string $arguments = null ): array{
        if( $arguments != null )
            return explode('/', $arguments ?? '');

        return [];
    }


    /**
     * @Route("/activites/{slug}/liste/{arguments}", name="activity.module.list", requirements={"arguments"=".*"})
     */
    public function listActionModule(ActivityType $activityType, $arguments = null) {

        $arguments = $this->fetchArguments( $arguments );
        $module = $this->sModule->load( $activityType, $arguments );
        if( !$module ) return $this->redirectToRoute( 'home');

        return $this->render( $this->loadTemplate( 'list.html.twig', $module ), [
            'event' => $this->theEvent,
            'activityType' => $activityType,
            'activities' => $module->getList(),
            'options' => $module->getOptions(),
            'arguments' => $arguments,
        ]);
    }

    /**
     * @Route("/activites/{slug}/nouveau/{arguments}", name="activity.module.new", requirements={"arguments"=".*"})
     */
    public function newActionModule(ActivityType $activityType, Request $request, $arguments = null ) {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $arguments = $this->fetchArguments( $arguments );
        $module = $this->sModule->load( $activityType, $arguments );
        if( !$module ) return $this->redirectToRoute( 'home');

        $form = $module->getForm();
        $form->handleRequest( $request );
        if ( $form->isSubmitted() && $form->isValid() ) {
            $module->preSubmit( $request );
            $module->submit();
            return $this->redirectToRoute('activity.module.list', ['slug' => $activityType->getSlug(), 'arguments' => implode('/' ,$arguments ) ] );
        }

        return $this->render($this->loadTemplate( 'new.html.twig', $module ), [
            'event' => $this->theEvent,
            'form' => $form->createView(),
            'activity' => $module->getActivity(),
            'activityType' => $activityType,
            'options' => $module->getOptions(),
        ]);
    }

    /**
     * @Route("/activity/{slug}/rejoindre/{arguments}", name="activity.module.join", requirements={"arguments"=".*"})
     */
    public function joinActionModule(Activity $activity, $arguments = null ) {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $return_route = $this->redirectToRoute( 'activity.module.list', [
            'slug' => $activity->getType()->getSlug(),
            'arguments' => implode('/' ,[$activity->getRound()->getSlug()] )
        ]);


        if( !$this->sUser->canJoin( $activity ) )
            return $return_route;

        $activity->addPlayer( $this->sUser->getUser() );
        $this->getDoctrine()->getManager()->flush();

        return $return_route;
    }

    /**
     * @Route("/activity/{slug}/quitter/{arguments}", name="activity.module.leave", requirements={"arguments"=".*"})
     */
    public function leaveActionModule(Activity $activity, $arguments = null ) {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $return_route = $this->redirectToRoute( 'activity.module.list', [
            'slug' => $activity->getType()->getSlug(),
            'arguments' => implode('/' ,[$activity->getRound()->getSlug()] )
        ]);


        if( !$this->sUser->canLeave( $activity ) )
            return $return_route;

        $activity->removePlayer( $this->sUser->getUser() );
        $this->getDoctrine()->getManager()->flush();

        return $return_route;
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