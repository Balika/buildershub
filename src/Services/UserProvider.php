<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\Entity\User;
use App\Utils\EntityConfig;
use Doctrine\Persistence\ManagerRegistry as Doctrine;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
/**
 * Description of UserProvider
 *
 * @author Balika - BTL
 */
class UserProvider implements UserProviderInterface
{
    protected $doctrine;
    public function __construct(Doctrine $doctrine) {
        $this->doctrine = $doctrine;
        
    }
    public function loadUserByUsername($username)
    {        
        return $user = $this->doctrine->getRepository(EntityConfig::USER)->loadUserByUsername($username);              
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }
}
