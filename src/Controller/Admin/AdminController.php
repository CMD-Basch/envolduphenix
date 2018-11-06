<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use App\Entity\View;
use App\Form\ViewType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route("/admin/{type}", name="admin.home")
     */
    public function home( string $type ) {
        // TODO : Check access rights

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
     * @Route("/admin/{type}/{view}", name="admin.edit")
     */
    public function edit( string $type, View $view, Request $request ) {

        if( $view->getMenu()->getSlug() != $type || $view->getFixed() )
            return $this->redirectToRoute('home');

        $form = $this->createForm( ViewType::class, $view );

        $form->handleRequest( $request );
        if ( $form->isSubmitted() && $form->isValid() ) {
            $this->getDoctrine()->getManager()->persist( $view );
            $this->getDoctrine()->getManager()->flush();
            $this->redirectToRoute('admin.edit', [ 'type' => $type, 'view' => $view ]);
        }


        return $this->render( 'envol/pages/admin/admin-form-view.html.twig', [
            'view' => $view,
            'type' => $type,
            'form' => $form->createView(),
        ] );
    }

}