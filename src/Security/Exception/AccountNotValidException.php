<?php
/**
 * Created by PhpStorm.
 * User: Basch
 * Date: 03/04/2018
 * Time: 00:05
 */

namespace App\Security\Exception;

use Symfony\Component\Security\Core\Exception\AccountStatusException;

class AccountNotValidException extends AccountStatusException {

    public function getMessageKey() {
        return 'Vous devez valider votre compte avant de pourvoir vous connecter.';
    }

}