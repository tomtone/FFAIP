<?php
namespace AppBundle\Security\Token;


use AppBundle\Service\CustomerData;
use AppBundle\Service\CustomerLogin;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class MagentoTokenFactory
{
    /**
     * @var CustomerData
     */
    private $customerData;
    /**
     * @var CustomerLogin
     */
    private $customerLogin;

    /**
     * MagentoTokenFactory constructor.
     * @param CustomerLogin $customerLogin
     * @param CustomerData $customerData
     */
    public function __construct(CustomerLogin $customerLogin, CustomerData $customerData)
    {
        $this->customerData = $customerData;
        $this->customerLogin = $customerLogin;
    }
    
    public function createToken($username, $password, $providerKey)
    {
        return new MagentoToken($username, $password, $providerKey);
    }

    /**
     * @param TokenInterface $token
     * @param $providerKey
     * @return MagentoToken
     */
    public function authenticateToken(TokenInterface $token, $providerKey)
    {
        $bearerToken = $this->customerLogin->login($token->getUsername(), $token->getCredentials());
        $customer = $this->customerData->request($bearerToken);
        $customer->setBearerToken($bearerToken);

        $token = new MagentoToken(
            $customer,
            $token->getCredentials(),
            $providerKey,
            $bearerToken,
            ['ROLE_USER']
        );
        $token->setAttribute('some', 'value');
        $token->setBearerToken($bearerToken);
        return $token;
    }
}