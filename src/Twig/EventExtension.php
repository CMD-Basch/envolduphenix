<?php

namespace App\Twig;

use App\Entity\Event;
use App\Entity\View;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class EventExtension extends AbstractExtension
{
    private $em;
    private $router;

    public function __construct( EntityManagerInterface $em, UrlGeneratorInterface $router )
    {
        $this->em = $em;
        $this->router = $router;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('view_url', [$this, 'viewUrl']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('event', [$this, 'getEvent'] ),
            new TwigFunction('view_url', [$this, 'viewUrl'] ),

        ];
    }

    public function getEvent(): ?Event
    {
        return $this->em->getRepository( Event::class )->findOneBy([ 'active' => true ],['start' => 'DESC']);
    }

    public function viewUrl( View $view ) {
        if( $view->getLink() ) {
            return $this->router->generate( $view->getLink() );
        }
        else {
            return $this->router->generate( 'page',[ 'id' => $view->getId() ] );
        }
    }



}
