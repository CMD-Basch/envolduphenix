<?php

namespace App\Twig;

use App\Entity\Event;
use App\Entity\View;
use App\Service\Event\EventService;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class EventExtension extends AbstractExtension
{
    private $sEvent;
    private $router;

    public function __construct( EventService $sEvent, UrlGeneratorInterface $router )
    {
        $this->sEvent = $sEvent;
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
        return $this->sEvent->getTheEvent();
    }

    public function viewUrl( View $view ) {
        if( $view->getModule() ) {
            return $this->router->generate( 'activity.module.list', [ 'slug' => $view->getModule()->getSlug() ] );
        }
        else {
            return $this->router->generate( 'page',[ 'slug' => $view->getSlug() ] );
        }
    }



}
