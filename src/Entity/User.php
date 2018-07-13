<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $user_id;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user_first_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user_last_name;

    /**
     * @var array
     *
     * @ORM\Column(type="json")
     */
    private $roles = [];


    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $user_deleted;

    /**
     * @return boolean
     */
    public function getUserDeleted()
    {
        return $this->user_deleted;
    }

    /**
     * @param array $user_deleted
     */
    public function setUserDeleted($user_deleted): void
    {
        $this->user_deleted = $user_deleted;
    }

    /**
     * @return integer
     */
    public function getUserId() : integer
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function getUserFirstName()
    {
        return $this->user_first_name;
    }

    /**
     * @param mixed $user_first_name
     */
    public function setUserFirstName($user_first_name): void
    {
        $this->user_first_name = $user_first_name;
    }

    /**
     * @return mixed
     */
    public function getUserLastName()
    {
        return $this->user_last_name;
    }

    /**
     * @param mixed $user_last_name
     */
    public function setUserLastName($user_last_name): void
    {
        $this->user_last_name = $user_last_name;
    }


    /**
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        // Afin d'être sûr qu'un user a toujours au moins 1 rôle
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword() : ?string
    {
        return $this->password;
    }

    /**
     * @param $password
     */
    public function setPassword(string $password) : void
    {
        $this->password=$password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt() : ?string
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername() : ?string
    {
        return $this->username;
    }

    public function setUsername(string $user_login) : void
    {
        $this->username = $user_login;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials() : void
    {
        //unused
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()  : string
    {
        return serialize([$this->user_id, $this->username, $this->password]);
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized) : void
    {
        [$this->user_id, $this->username, $this->password] = unserialize($serialized, ['allowed_classes' => false]);
    }
}
