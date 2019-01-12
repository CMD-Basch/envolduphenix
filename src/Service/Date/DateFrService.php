<?php

namespace App\Service\Date;


class DateFrService
{

    const DAYS_SHORT = [
        1 => 'lun',
        2 => 'mar',
        3 => 'mer',
        4 => 'jeu',
        5 => 'ven',
        6 => 'sam',
        0 => 'dim',
    ];

    const DAYS_LONG = [
        1 => 'lundi',
        2 => 'mardi',
        3 => 'mercredi',
        4 => 'jeudi',
        5 => 'vendredi',
        6 => 'samedi',
        0 => 'dimanche',
    ];


    public function dayAndNb( \DateTimeInterface $date ): string {
        return ucfirst($this->getDayLong($date)).' '.$date->format('j');
    }

    public function dayAndNbSlug( \DateTimeInterface $date ): string {
        return $this->getDayLong($date).'-'.$date->format('j');
    }

    public function fromToFr( \DateTimeInterface $from, \DateTimeInterface $to  ): string {

        $dayFrom = $from->format('z');
        $dayTo = $to->format('z');

        if( $dayFrom == $dayTo || $to->format('h') < 5 ){
            return $this->getDayShort( $from ) . ' de ' . $from->format('H\hi') . ' à '. $to->format('H\hi');
        }
        else {
            return 'du ' . $this->getDayShort( $from ) . ' à '.$from->format('H\hi').
                ' au '.$this->getDayShort( $to ) . ' à '.$to->format('H\hi');
        }



    }

    public function getDayShort( \DateTimeInterface $date ): string{
        return self::DAYS_SHORT[$date->format('w')] ?? '';
    }

    public function getDayLong( \DateTimeInterface $date ): string{
        return self::DAYS_LONG[$date->format('w')] ?? '';
    }
}