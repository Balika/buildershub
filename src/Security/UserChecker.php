<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Security;

use App\Entity\User;
use App\Exceptions\InactiveAccountException;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Description of UserChecker
 *
 * @author Balika - MRH
 */
class UserChecker implements UserCheckerInterface{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }
        // user is inactive, show a generic Account Not Found message.
        if (!$user->getIsActive()) {
            throw new InactiveAccountException('Your account has not yet been activated');
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }

        // user account is expired, the user may be notified
        if ($user->getExpired()) {
            throw new AccountExpiredException('Your account has expired. Contact site administrator');
        }
    }
}
