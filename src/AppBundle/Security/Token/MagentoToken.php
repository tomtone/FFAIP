<?php
namespace AppBundle\Security\Token;

use AppBundle\Security\User\Customer;
use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class MagentoToken
 * @package AppBundle\Security\Token
 */
class MagentoToken extends AbstractToken
{
    /**
     * MagentoToken constructor.
     * @param Customer|string $user
     * @param $password
     * @param $bearerToken
     * @param $providerKey
     * @param array $roles
     */
    public function __construct($user, $password, $providerKey, $bearerToken = null, array $roles = array())
    {
        $this->setUser($user);
        $this->setAttributes([
            'credentials' => $password,
            'providerKey' => $providerKey,
            'bearerToken' => $bearerToken
        ]);
        $this->setAuthenticated(true);
        parent::__construct($roles);
    }

    public function getCredentials()
    {
        return $this->getAttribute('credentials');
    }

    public function getProviderKey()
    {
        return $this->getAttribute('providerKey');
    }

    public function getBearerToken()
    {
        return $this->getAttribute('bearerToken');
    }
}