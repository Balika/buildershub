<?php

namespace App\Utils;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * This class is used to provide an example of integrating simple classes as
 * services into a Symfony application.
 *
 * @author Balika Edmon Mwinbamon <balikaem@gmail.com>
 */
class Globals {

    private static $currentUser;
    

    /**
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage) {
        if ($tokenStorage->getToken() != null) {
            self::$currentUser = $tokenStorage->getToken()->getUser();
        }
    }

    public static function getSupplier() {
        if (self::$currentUser != null && self::$currentUser instanceof User) {
            return self::$currentUser->getSupplier();
        }
        return null;
    }

    public static function getUser() {
        // $instance = new self();
        return self::$currentUser;
    }

    
    static function setCurrentUser(User $currentUser) {
        self::$currentUser = $currentUser;
    }



}
