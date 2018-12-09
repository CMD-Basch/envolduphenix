<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use App\Entity\User;
use App\Entity\View;
use App\Form\ViewType;
use App\Service\Form\WeightService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    private $weightService;

    public function __construct( WeightService $weightService )
    {
        $this->weightService = $weightService;
    }

    /**
     * @Route("/admin", name="admin.home")
     */
    public function home() {

        /** @var User $user */
        $user = $this->getUser();

        dump($user);

        return $this->render( 'envol/pages/admin/admin-home.html.twig', [
            'user' => $user,
        ] );

    }

    /**
     * @Route("/admin/weight/{type}/{view}/{act}", name="admin.view.weight")
     */
    public function viewWeight( string $type, View $view, string $act ) {
        if( $view->getMenu()->getSlug() != $type )
            return $this->redirectToRoute('home');

        $this->weightService->changeWeight( $view, $act );

        return $this->redirectToRoute('admin.view.list', ['type' => $type]);
    }

    /**
     * @Route("/admin/active/{type}/{view}/{act}", name="admin.view.active")
     */
    public function viewDelete( string $type, View $view, string $act) {
        if( $view->getMenu()->getSlug() != $type )
            return $this->redirectToRoute('home');

        if( !$view->getFixed() ) {
            $view->setActive( $act == 'on' );
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->redirectToRoute('admin.view.list', ['type' => $type]);
    }

    /**
     * @Route("/admin/delete/{type}/{view}", name="admin.view.delete")
     */
    public function viewActive( string $type, View $view ) {
        if( $view->getMenu()->getSlug() != $type )
            return $this->redirectToRoute('home');

        $view->setDeleted( true );
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('admin.view.list', ['type' => $type]);
    }

    /**
     * @Route("/admin/list/{type}", name="admin.view.list")
     */
    public function viewList( string $type ) {
        // TODO : Check access type rights

        $menu = $this->getDoctrine()->getRepository( Menu::class )->findOneBy( ['slug' => $type ] );
        if( !$menu )
            return $this->redirectToRoute( 'home');

        $views = $this->getDoctrine()->getRepository( View::class )->findBy( ['menu' => $menu, 'deleted' => false ], ['weight' => 'ASC'] );

        return $this->render( 'envol/pages/admin/admin-list.html.twig', [
            'menu' => $menu,
            'views' => $views,
            'type' => $type,
        ] );
    }

    /**
     * @Route("/admin/add/{type}/", name="admin.view.add")
     */
    public function viewAdd( string $type, Request $request ) {

        //$this->getDoctrine()->getManager()->refresh($view);

        $menu = $this->getDoctrine()->getRepository( Menu::class )->findOneBy( ['slug' => $type ] );
        if( !$menu )
            return $this->redirectToRoute( 'home');

        $view = new View();
        $view->setMenu( $menu );

        $form = $this->createForm( ViewType::class, $view );

        $form->handleRequest( $request );
        if ( $form->isSubmitted() && $form->isValid() ) {
            $count = count( $this->getDoctrine()->getRepository( View::class)->findBy(['menu' => $menu->getId()]));
            $view
                ->setWeight( $count )
                ->setActive( false )
                ->setFixed( false )
                ->setDeleted( false );

            $this->getDoctrine()->getManager()->persist( $view );
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.view.edit', [ 'type' => $type, 'view' => $view->getId() ]);
        }


        return $this->render( 'envol/pages/admin/admin-form-add.html.twig', [
            'view' => $view,
            'type' => $type,
            'form' => $form->createView(),
        ] );
    }

    /**
     * @Route("/admin/edit/{type}/{view}", name="admin.view.edit")
     */
    public function viewEdit( string $type, View $view, Request $request ) {

        //$this->getDoctrine()->getManager()->refresh($view);

        if( $view->getMenu()->getSlug() != $type || $view->getFixed() )
            return $this->redirectToRoute('home');

        $form = $this->createForm( ViewType::class, $view );

        $form->handleRequest( $request );
        if ( $form->isSubmitted() && $form->isValid() ) {
            $this->getDoctrine()->getManager()->persist( $view );
            $this->getDoctrine()->getManager()->flush();
            dump('valid');
            return $this->redirectToRoute('admin.view.edit', [ 'type' => $type, 'view' => $view->getId() ]);
        }

        return $this->render( 'envol/pages/admin/admin-form-edit.html.twig', [
            'view' => $view,
            'type' => $type,
            'form' => $form->createView(),
        ] );
    }

}