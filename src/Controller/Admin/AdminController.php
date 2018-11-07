<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use App\Entity\User;
use App\Entity\View;
use App\Form\ViewType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
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
     * @Route("/admin/list/{type}", name="admin.list")
     */
    public function list( string $type ) {
        // TODO : Check access type rights

        $menu = $this->getDoctrine()->getRepository( Menu::class )->findOneBy( ['slug' => $type ] );
        if( !$menu )
            return $this->redirectToRoute( 'home');

        $views = $this->getDoctrine()->getRepository( View::class )->findBy( ['menu' => $menu ], ['weight' => 'ASC'] );
        dump( $views );

        return $this->render( 'envol/pages/admin/admin-list.html.twig', [
            'menu' => $menu,
            'views' => $views,
            'type' => $type,
        ] );
    }

    /**
     * @Route("/admin/add/{type}/", name="admin.add")
     */
    public function add( string $type, Request $request ) {

        //$this->getDoctrine()->getManager()->refresh($view);

        $menu = $this->getDoctrine()->getRepository( Menu::class )->findOneBy( ['slug' => $type ] );
        if( !$menu )
            return $this->redirectToRoute( 'home');

        $view = new View();
        $view->setMenu( $menu );

        $form = $this->createForm( ViewType::class, $view );

        $form->handleRequest( $request );
        if ( $form->isSubmitted() && $form->isValid() ) {
            $this->getDoctrine()->getManager()->persist( $view );
            $this->getDoctrine()->getManager()->flush();
            dump('valid');
            return $this->redirectToRoute('admin.edit', [ 'type' => $type, 'view' => $view->getId() ]);
        }


        return $this->render( 'envol/pages/admin/admin-form-add.html.twig', [
            'view' => $view,
            'type' => $type,
            'form' => $form->createView(),
        ] );
    }

    /**
     * @Route("/admin/edit/{type}/{view}", name="admin.edit")
     */
    public function edit( string $type, View $view, Request $request ) {

        //$this->getDoctrine()->getManager()->refresh($view);

        if( $view->getMenu()->getSlug() != $type || $view->getFixed() )
            return $this->redirectToRoute('home');

        $form = $this->createForm( ViewType::class, $view );

        $form->handleRequest( $request );
        if ( $form->isSubmitted() && $form->isValid() ) {
            $this->getDoctrine()->getManager()->persist( $view );
            $this->getDoctrine()->getManager()->flush();
            dump('valid');
            return $this->redirectToRoute('admin.edit', [ 'type' => $type, 'view' => $view->getId() ]);
        }


        return $this->render( 'envol/pages/admin/admin-form-edit.html.twig', [
            'view' => $view,
            'type' => $type,
            'form' => $form->createView(),
        ] );
    }

}