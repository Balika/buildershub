<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity\Base;

use App\Model\GroupableInterface;
use App\Model\GroupInterface;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Description of BaseUser
 *
 * @author Balika - BTL
 */
abstract class BaseUser  implements UserInterface, GroupableInterface, EquatableInterface, Serializable {

    const ROLE_DEFAULT = 'ROLE_USER';
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $username;

    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $usernameCanonical;

    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $emailCanonical;

    /**
     * @ORM\Column(type="boolean")
     * 
     */
    protected $enabled;

    /**
     * @ORM\Column(type="boolean")
     * 
     */
    protected $credentialsExpired;

    /**
     * @ORM\Column(type="datetime")
     * 
     */
    protected $credentialsExpireAt;

    /**
     * @ORM\Column(type="boolean")
     * 
     */
    protected $expired;

    /**
     * @ORM\Column(type="boolean")
     * 
     */
    protected $locked;

    /**
     * @ORM\Column(type="datetime")
     * 
     */
    protected $expiresAt;

    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $salt;

    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $password;
    protected $plainPassword;

    /**
     * @ORM\Column(type="datetime")
     * 
     */
    protected $lastLogin;

    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $confirmationToken;

    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $passwordResetToken;

    /**
     * @ORM\Column(type="datetime")
     * 
     */
    protected $passwordRequestedAt;

    /**
     * @var Collection
     */
    protected $groups;

    /**
     * @ORM\Column(type="array")
     * 
     */
    protected $roles;

    /**
     * User constructor.
     */
    public function __construct() {
        $this->enabled = false;
        $this->roles = array();
    }

    /**
     * {@inheritdoc}
     */
    public function addRole($role) {
        $role = strtoupper($role);
        if ($role === static::ROLE_DEFAULT) {
            return $this;
        }

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize() {
        return serialize(array(
            $this->password,
            $this->salt,
            $this->usernameCanonical,
            $this->username,
            $this->enabled,
            $this->id,
            $this->email,
            $this->emailCanonical,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized) {
        $data = unserialize($serialized);

        if (13 === count($data)) {
            // Unserializing a User object from 1.3.x
            unset($data[4], $data[5], $data[6], $data[9], $data[10]);
            $data = array_values($data);
        } elseif (11 === count($data)) {
            // Unserializing a User from a dev version somewhere between 2.0-alpha3 and 2.0-beta1
            unset($data[4], $data[7], $data[8]);
            $data = array_values($data);
        }

        list(
                $this->password,
                $this->salt,
                $this->usernameCanonical,
                $this->username,
                $this->enabled,
                $this->id,
                $this->email,
                $this->emailCanonical
                ) = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials() {
        $this->plainPassword = null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsernameCanonical() {
        return $this->usernameCanonical;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt() {
        return $this->salt;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmailCanonical() {
        return $this->emailCanonical;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function getPlainPassword() {
        return $this->plainPassword;
    }

    /**
     * Gets the last login time.
     *
     * @return DateTime
     */
    public function getLastLogin() {
        return $this->lastLogin;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfirmationToken() {
        return $this->confirmationToken;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles() {
        $roles = $this->roles;

        foreach ($this->getGroups() as $group) {
            $roles = array_merge($roles, $group->getRoles());
        }

        // we need to make sure to have at least one role
        $roles[] = static::ROLE_DEFAULT;

        return array_unique($roles);
    }

    /**
     * {@inheritdoc}
     */
    public function hasRole($role) {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    public function isEnabled() {
        return $this->enabled;
    }

    /**
     * {@inheritdoc}
     */
    public function isSuperAdmin() {
        return $this->hasRole(static::ROLE_SUPER_ADMIN);
    }

    /**
     * {@inheritdoc}
     */
    public function removeRole($role) {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setUsernameCanonical($usernameCanonical) {
        $this->usernameCanonical = $usernameCanonical;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setSalt($salt) {
        $this->salt = $salt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmailCanonical($emailCanonical) {
        $this->emailCanonical = $emailCanonical;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setEnabled($boolean) {
        $this->enabled = (bool) $boolean;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setSuperAdmin($boolean) {
        if (true === $boolean) {
            $this->addRole(static::ROLE_SUPER_ADMIN);
        } else {
            $this->removeRole(static::ROLE_SUPER_ADMIN);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPlainPassword($password) {
        $this->plainPassword = $password;

        return $this;
    }

    public function getCredentialsExpired() {
        return $this->credentialsExpired;
    }

    public function getCredentialsExpireAt() {
        return $this->credentialsExpiredAt;
    }

    public function getExpired() {
        return $this->expired;
    }

    public function getExpiresAt() {
        return $this->expiresAt;
    }

    public function getPasswordResetToken() {
        return $this->passwordResetToken;
    }

    public function setCredentialsExpired($credentialsExpired = null) {
        $this->credentialsExpired = $credentialsExpired;
        return $this;
    }

    public function setCredentialsExpireAt(DateTime $credentialsExpireAt = null) {
        $this->credentialsExpireAt = $credentialsExpireAt;
        return $this;
    }

    public function setExpired($expired = null) {
        $this->expired = $expired;
        return $this;
    }

    public function setExpiresAt(DateTime $expiresAt = null) {
        $this->expiresAt = $expiresAt;
        return $this;
    }

    public function setPasswordResetToken($passwordResetToken = null) {
        $this->passwordResetToken = $passwordResetToken;
        return $this;
    }

    public function getLocked() {
        return $this->locked;
    }

    public function setLocked($locked = null) {
        $this->locked = $locked;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastLogin(DateTime $time = null) {
        $this->lastLogin = $time;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setConfirmationToken($confirmationToken) {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPasswordRequestedAt(DateTime $date = null) {
        $this->passwordRequestedAt = $date;

        return $this;
    }

    /**
     * Gets the timestamp that the user requested a password reset.
     *
     * @return null|DateTime
     */
    public function getPasswordRequestedAt() {
        return $this->passwordRequestedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function isPasswordRequestNonExpired($ttl) {
        return $this->getPasswordRequestedAt() instanceof DateTime &&
                $this->getPasswordRequestedAt()->getTimestamp() + $ttl > time();
    }

    /**
     * {@inheritdoc}
     */
    public function setRoles(array $roles) {
        $this->roles = array();

        foreach ($roles as $role) {
            $this->addRole($role);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getGroups() {
        return $this->groups ?: $this->groups = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getGroupNames() {
        $names = array();
        foreach ($this->getGroups() as $group) {
            $names[] = $group->getName();
        }

        return $names;
    }

    /**
     * {@inheritdoc}
     */
    public function hasGroup($name) {
        return in_array($name, $this->getGroupNames());
    }

    /**
     * {@inheritdoc}
     */
    public function addGroup(GroupInterface $group) {
        if (!$this->getGroups()->contains($group)) {
            $this->getGroups()->add($group);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeGroup(GroupInterface $group) {
        if ($this->getGroups()->contains($group)) {
            $this->getGroups()->removeElement($group);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString() {
        return (string) $this->getUsername();
    }

}
