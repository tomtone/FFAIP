<?php
namespace AppBundle\Security\Provider;
use AppBundle\Security\User\Customer;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;


class CustomerProvider implements UserProviderInterface
{
    /**
     * @param string $username
     *
     * @return User
     */
    public function loadUserByUsername($username)
    {
        return $username;
        #throw new UsernameNotFoundException('Username nicht gefunden');
    }

    /**
     * @param UserInterface $user
     *
     * @return User
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof Customer) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }
        return $this->loadUserByUsername($user);
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class === 'AppBundle\Security\User\Customer';
    }
}