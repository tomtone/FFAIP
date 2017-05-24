<?php
namespace AppBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

class Customer implements UserInterface, EquatableInterface
{
    /**
     * @var array
     */
    protected $roles = ['ROLE_USER'];
    
    /**
     * @var
     */
    private $username;

    /**
     * Customer constructor.
     * @param $email
     */
    public function __construct($email)
    {
        $this->username = $email;
    }
    public function isEqualTo(UserInterface $user)
    {
        if ($this->username !== $user->getUsername()) {
            return false;
        }
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getPassword()
    {
        return '';
    }

    public function getSalt()
    {
        return '';
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

}