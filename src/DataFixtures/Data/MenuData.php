<?php

namespace App\DataFixtures\Data;


class MenuData
{
    public static $DATA = [
        [
            'id' => 1,
            'name' => 'L\'évènement',
            'weight' => '0',
            'active' => '1',
            'color' => 'bd-bleu',
            'pic' => 'blk'
        ],
        [
            'id' => 2,
            'name' => 'Jeu de rôle',
            'weight' => '1',
            'active' => '1',
            'color' => 'bd-orange',
            'pic' => 'jdr'
        ],
        [
            'id' => 3,
            'name' => 'Wargame',
            'weight' => '2',
            'active' => '1',
            'color' => 'bd-bleu',
            'pic' => 'wg'
        ],
        [
            'id' => 4,
            'name' => 'Jeu de société',
            'weight' => '3',
            'active' => '1',
            'color' => 'bd-orange',
            'pic' => 'jds'
        ],
        [
            'id' => 5,
            'name' => 'Escrime',
            'weight' => '4',
            'active' => '1',
            'color' => 'bd-bleu',
            'pic' => 'blk'
        ],
    ];
}