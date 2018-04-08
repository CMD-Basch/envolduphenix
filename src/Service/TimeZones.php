<?php

namespace App\Service;


class TimeZones
{

    private const TIME_CODES = [
        'vendredi-soir' => [
            'name' => 'Vendredi soir',
            'start' => 21,
            'end' => 28,
            'day' => 0,
        ],
        'samedi-journee' => [
            'name' => 'Samedi journée',
            'start' => 11,
            'end' => 18,
            'day' => 1,
        ],
        'samedi-soir' => [
            'name' => 'Samedi soir',
            'start' => 21,
            'end' => 28,
            'day' => 1,
        ],
        'dimanche-journee' => [
            'name' => 'Dimanche journée',
            'start' => 11,
            'end' => 16,
            'day' => 2,
        ],
    ];

    public function getAll() {
        return self::TIME_CODES;
    }

    public function checkTimeCode( $code ) {
        if( $code )
            return array_key_exists( $code, self::TIME_CODES );
        else
            return false;
    }


}