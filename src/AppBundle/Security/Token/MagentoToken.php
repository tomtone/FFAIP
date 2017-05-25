<?php
namespace AppBundle\Security\Token;
use AppBundle\Security\User\Customer;
use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

/**
 * Class MagentoToken
 * @package AppBundle\Security\Token
 */
class MagentoToken extends AbstractToken
{
    /**
     * @var array
     */
    private $username;
    /**
     * @var
     */
    private $credentials;
    /**
     * @var
     */
    private $providerKey;
    /**
     * @var
     */
    private $bearerToken;

    /**
     * MagentoToken constructor.
     * @param Customer|string $user
     * @param $password
     * @param $bearerToken
     * @param $providerKey
     * @param array $roles
     */
    public function __construct($user, $password, $providerKey, $bearerToken = null, array $roles = array()){
        if($user instanceof Customer){
            $this->username = $user->__toString();
        }
        $this->setUser($user);
        $this->credentials = $password;
        $this->providerKey = $providerKey;

        $this->setAuthenticated(true);
        $this->bearerToken = $bearerToken;
        parent::__construct($roles);
    }
    /**
     * {@inheritdoc}
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    public function setBearerToken($bearerToken)
    {
        $this->bearerToken = $bearerToken;
    }

    public function getBearerToken()
    {
        return $this->bearerToken;
    }
    /**
     * Returns the provider key.
     *
     * @return string The provider key
     */
    public function getProviderKey()
    {
        return $this->providerKey;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        parent::eraseCredentials();

        $this->credentials = null;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize(array($this->credentials, $this->providerKey, parent::serialize()));
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        list($this->credentials, $this->providerKey, $parentStr) = unserialize($serialized);
        parent::unserialize($parentStr);
    }
}