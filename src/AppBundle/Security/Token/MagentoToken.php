<?php
namespace AppBundle\Security\Token;
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
     * @var array
     */
    private $roles = array();
    /**
     * @var
     */
    private $providerKey;

    /**
     * MagentoToken constructor.
     * @param array $username
     * @param $password
     * @param array $roles
     * @param $providerKey
     */
    public function __construct($username, $password, $providerKey, array $roles = array()){
        parent::__construct($roles);
        $this->username = $username;
        $this->setUser($username);
        $this->credentials = $password;
        $this->roles = $roles;
        $this->providerKey = $providerKey;

        $this->setAuthenticated(count($roles) > 0);
    }
    /**
     * {@inheritdoc}
     */
    public function getCredentials()
    {
        return $this->credentials;
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