<?php

namespace App\Twig;

use App\Entity\Event;
use App\Entity\View;
use App\Service\Date\DateFrService;
use App\Service\Event\EventService;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class DateExtension extends AbstractExtension
{
    private $sDateFr;

    public function __construct( DateFrService $sDateFr )
    {
        $this->sDateFr = $sDateFr;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('dayAndNb', [$this, 'dayAndNb']),
            new TwigFilter('dayAndNbSlug', [$this, 'dayAndNbSlug']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('fromToFr', [$this, 'fromToFr'] ),
        ];
    }

    public function dayAndNb( \DateTimeInterface $date ) {
        return $this->sDateFr->dayAndNb( $date );
    }

    public function dayAndNbSlug( \DateTimeInterface $date ) {
        return $this->sDateFr->dayAndNbSlug( $date );
    }

    public function fromToFr( \DateTimeInterface $from, \DateTimeInterface $to  ) {
        return $this->sDateFr->fromToFr( $from, $to );
    }



}
