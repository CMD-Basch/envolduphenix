<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\ActivityType;
use App\Entity\View;
use App\Model\ModuleInterface;
use App\Service\Event\EventService;
use App\Service\Module\ModuleService;
use App\Service\User\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     * @Route("/activite/{longSlug}/liste/{arguments}", name="activity.module.list", requirements={"longSlug"="[^\/]+\/[^\/]+","arguments"=".*"})
     */
    public function listActionModule(View $view, $arguments = null) {
        $activityType = $view->getModule();
        if( !$activityType )return $this->redirectToRoute('home');

        $arguments = $this->fetchArguments( $arguments );
        $module = $this->sModule->load( $activityType, $arguments );
        if( !$module ) return $this->redirectToRoute( 'home');

        return $this->render( $this->loadTemplate( 'list.html.twig', $module ), [
            'title' => $view->generateTitle(),
            'view' => $view,
            'event' => $this->theEvent,
            'activityType' => $activityType,
            'activities' => $module->getList(),
            'options' => $module->getOptions(),
            'arguments' => $arguments,
        ]);
    }

    /**
     * @Route("/activites/{longSlug}/nouveau/{arguments}", name="activity.module.new", requirements={"longSlug"="[^\/]+\/[^\/]+","arguments"=".*"})
     */
    public function newActionModule(View $view, Request $request, $arguments = null ) {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');


        $activityType = $view->getModule();
        if( !$activityType )return $this->redirectToRoute('home');

        $arguments = $this->fetchArguments( $arguments );

        if( !$this->theEvent->isMasterCanRegister() ) {
            return $this->redirectToRoute( 'activity.module.list', ['longSlug' => $view->getLongSlug(), 'arguments' => implode('/' ,$arguments ) ] );
        }

        $module = $this->sModule->load( $activityType, $arguments );
        if( !$module ) return $this->redirectToRoute( 'home');

        $form = $module->getForm();
        $form->handleRequest( $request );
        if ( $form->isSubmitted() && $form->isValid() ) {
            $module->preSubmit( $request );
            $module->submit();
            return $this->redirectToRoute('activity.module.list', ['longSlug' => $view->getLongSlug(), 'arguments' => implode('/' ,$arguments ) ] );
        }

        return $this->render($this->loadTemplate( 'new.html.twig', $module ), [
            'title' => $view->generateTitle(),
            'view' => $view,
            'event' => $this->theEvent,
            'form' => $form->createView(),
            'activity' => $module->getActivity(),
            'activityType' => $activityType,
            'options' => $module->getOptions(),
        ]);
    }

    /**
     * @Route("/activity/{v_slug}/{a_slug}/{action}/{arguments}", name="activity.module.act", requirements={"v_slug"="[^\/]+\/[^\/]+","arguments"=".*"})
     * @ParamConverter("view", options={"mapping": {"v_slug": "longSlug"}})
     * @ParamConverter("activity", options={"mapping": {"a_slug": "slug"}})
     */
    public function joinActionModule(View $view, Activity $activity, string $action, Request $request, $arguments = null ) {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $typeSlug = $activity->getType()->getSlug();
        $arguments = $this->fetchArguments( $arguments );

        if($request->isXmlHttpRequest() && $requestType = $request->request->get('type')){
            $typeSlug = $requestType;
        }

        $activityType = $this->getDoctrine()->getManager()->getRepository( ActivityType::class )->findOneBy(['slug' => $typeSlug ]);

        $module = $this->sModule->load( $activityType, $arguments );
        $module->setActivity( $activity );

        $return_route = $this->redirectToRoute( 'activity.module.list', [
            'longSlug' => $view->getLongSlug(),
            'arguments' => implode('/' ,$module->getArgumentsAfterAjaxAction() )
        ]);

        if( !$activity->getEvent()->isPlayerCanRegister() ) return $return_route;

        switch($action){
            case 'rejoindre' :
                if( $this->sUser->canJoin( $activity ) )
                    $activity->addPlayer( $this->sUser->getUser() );
                break;
            case 'quitter' :
                $activity->removePlayer( $this->sUser->getUser() );
                break;
        }

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