<?php

namespace App\Controller;
use App\Entity\Parrainer;
use App\Entity\View;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class BaseController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function home(AuthorizationCheckerInterface $authorizationChecker) {

        $parrainers = $this->getDoctrine()->getRepository( Parrainer::class )->findBy([], ['weight' => 'ASC'] );

        return $this->render('envol/home.html.twig', ['parrainers' => $parrainers]);
    }

    /**
     * @Route("/page/{id}", name="page")
     */
    public function textView( View $view ) {

        $title = [
            'color' =>  $view->getMenu()->getColor(),
            'pic' => $view->getMenu()->getPic(),
            'name' => $view->getMenu()->getName(),
        ];

        $page = $this->container->get('twig')->createTemplate( $view->getContent() ?? '' )->render( [] );

        $title['pic'] = 'images/title/'.$title['pic'].'.png';

        return $this->render('envol/pages/text.html.twig', array(
            'title' => $title,
            'view' => $view,
            'page' => $page,
        ));

    }
}