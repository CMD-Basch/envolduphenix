<?php

namespace App\Twig;

use App\Service\Event\EventService;
use App\Service\User\UserService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ServiceExtension extends AbstractExtension
{
    private $sUser;
    private $sEvent;


    public function __construct(
        UserService $sUser,
        EventService $sEvent)
    {
        $this->sUser = $sUser;
        $this->sEvent = $sEvent;
    }

    public function getFilters(): array
    {
        return [];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('sUser', [$this, 'getUserService'] ),
            new TwigFunction('sEvent', [$this, 'getEventService'] ),
        ];
    }

    public function getUserService(): UserService
    {
        return $this->sUser;
    }

    public function getEventService(): EventService
    {
        return $this->sEvent;
    }

}
