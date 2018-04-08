<?php

namespace App\Service;


use App\Entity\View;
use App\Repository\MenuRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MenuLoader
{

    private $router;
    private $repository;

    public function __construct( UrlGeneratorInterface $router, MenuRepository $repository)
    {
        $this->router = $router;
        $this->repository = $repository;
    }

    public function url( View $view ) {
        if( $view->getLink() ) {
            return $this->router->generate( $view->getLink() );
        }
        else {
            return $this->router->generate( 'page',[ 'id' => $view->getId() ] );
        }
    }

    public function getList() {
        return $this->repository->findForPrint();
    }
}