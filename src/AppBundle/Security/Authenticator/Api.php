<?php
namespace AppBundle\Security\Authenticator;

use AppBundle\Security\Token\MagentoToken;
use AppBundle\Service\CustomerLogin;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\SimpleFormAuthenticatorInterface;

/**
 * Class Api
 * @package AppBundle\Security\Authenticator
 */
class Api implements SimpleFormAuthenticatorInterface
{
    /**
     * @var CustomerLogin
     */
    private $customerLogin;

    /**
     * Api constructor.
     * @param CustomerLogin $customerLogin
     */
    public function __construct(CustomerLogin $customerLogin)
    {
        $this->customerLogin = $customerLogin;
    }
    /**
     * Create AuthenticationToken for valid User.
     *
     * @param TokenInterface $token
     * @param UserProviderInterface $userProvider
     * @param                       $providerKey
     * @return MagentoToken
     */
    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        $bearerToken = $this->customerLogin->login($token->getUsername(), $token->getCredentials());
        var_dump($bearerToken);
        die();
        return new MagentoToken(
            $token->getUsername(),
            $token->getCredentials(),
            $providerKey,
            ['ROLE_USER']
        );
    }

    /**
     * Validate if given Token is supported.
     *
     * @param TokenInterface $token
     * @param                $providerKey
     *
     * @return bool
     */
    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof MagentoToken
        && $token->getProviderKey() == $providerKey;
    }

    /**
     * Create Token from given providerKey.
     *
     * @param Request $request
     * @param         $username
     * @param         $password
     * @param         $providerKey
     *
     * @return UsernamePasswordToken
     */
    public function createToken(Request $request, $username, $password, $providerKey)
    {
        return new MagentoToken($username, $password, $providerKey);
    }
}