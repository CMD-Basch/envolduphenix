<?php

namespace App\Controller;
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
        return $this->render('envol/home.html.twig');
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
            'page' => $page,
        ));

    }
}