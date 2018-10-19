<?php

namespace App\DataFixtures\Data;


class UserData
{
    public static $DATA = [
        [
            'id' => 1,
            'username' => 'Basch',
            'password' => 'pass',
            'email' => 'ced_46000@hotmail.com',
            'roles' => [ 'ROLE_SUPER_ADMIN' ],
        ],
        [
            'id' => 2,
            'username' => 'Vera',
            'password' => 'pass',
            'email' => 'manu@mail.com',
            'roles' => [ 'ROLE_USER' ],
        ],
        [
            'id' => 3,
            'username' => 'Hugo',
            'password' => 'pass',
            'email' => 'hugo@mail.com',
            'roles' => [ 'ROLE_USER' ],
        ],
    ];
}