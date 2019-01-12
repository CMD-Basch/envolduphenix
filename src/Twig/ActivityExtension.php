<?php

namespace App\Twig;

use App\Entity\Activity;
use App\Entity\View;
use App\Service\User\UserService;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ActivityExtension extends AbstractExtension
{
    private $sUser;
    private $router;

    public function __construct(UserService $sUser, UrlGeneratorInterface $router )
    {
        $this->sUser = $sUser;
        $this->router = $router;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('aButton', [$this, 'getButton', ['is_safe' => ['html']]]),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('aButton', [$this, 'getButton', ['is_safe' => ['html']]]),

        ];
    }

    public function getButton(Activity $activity, View $view ): string
    {
        $user = $this->sUser->getUser();

        if( $activity->isMaster( $user ) ){
            return '';
        }
        elseif( $activity->isPlayer( $user ) ) {
            $url = $this->router->generate('activity.module.act',['v_slug'=> $view->getLongSlug(), 'a_slug' => $activity->getSlug(), 'action' => 'quitter'] );
            return '<a class="btn btn-outline-primary btn-table" role="button" data-ajax-button="true" href="'. $url .'">Quitter</a>';
        }
        elseif( !$activity->isFreeSlots() ) {
            return '<a class="btn btn-outline-secondary disabled" role="button" tabindex="-1" aria-disabled="true" href="#">Partie pleine</a>';
        }
        elseif( $this->sUser->isFreeTimeActivity($activity) ) {
            $url = $this->router->generate('activity.module.act',['v_slug'=> $view->getLongSlug(), 'a_slug' => $activity->getSlug(), 'action' => 'rejoindre'] );
            return '<a class="btn btn-outline-primary btn-table" role="button" data-ajax-button="true" href="'. $url .'">Rejoindre</a>';
        }
        else {
            return '';
        }

    }


}
