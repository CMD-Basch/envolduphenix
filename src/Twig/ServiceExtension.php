<?php

namespace App\Twig;

use App\Service\User\UserService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ServiceExtension extends AbstractExtension
{
    private $sUser;


    public function __construct( UserService $sUser )
    {
        $this->sUser = $sUser;
    }

    public function getFilters(): array
    {
        return [];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('sUser', [$this, 'getUserService'] ),
        ];
    }

    public function getUserService(): UserService
    {
        return $this->sUser;
    }

}
