<?php
namespace AppBundle\Http;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class RequestFactory
 * @package AppBundle\Http
 */
class RequestFactory
{
    /**
     * @var TokenInterface
     */
    protected $token;
    /**
     * @var string
     */
    private $shopUrl;
    /**
     * @var string
     */
    private $adminUser;
    /**
     * @var string
     */
    private $adminPassword;
    /**
     * @var TokenStorage
     */
    private $tokenStorage;
    /**
     * @var CacheItemPoolInterface
     */
    private $cacheAdapter;
    /**
     * @var Session
     */
    private $session;

    /**
     * RequestFactory constructor.
     *
     * @param string $shopUrl
     * @param string $adminUser
     * @param string $adminPassword
     * @param TokenStorage $tokenStorage
     * @param Session $session
     * @internal param CacheItemPoolInterface $cacheAdapter
     */
    public function __construct(string $shopUrl, string $adminUser, string $adminPassword, TokenStorage $tokenStorage, Session $session, CacheItemPoolInterface $cacheAdapter)
    {
        $this->shopUrl = $shopUrl;
        $this->adminUser = $adminUser;
        $this->adminPassword = $adminPassword;
        $this->tokenStorage = $tokenStorage;
        $this->token = $tokenStorage->getToken();
        $this->cacheAdapter = $cacheAdapter;
        $this->session = $session;

        if($this->session->has('cart_id') === false){
            $this->createGuestCart();
        }
    }

    /**
     * @return Request
     */
    public function getCartRequest()
    {
        if($this->token instanceof AnonymousToken){
            $request = $this->buildRequest('GET', 'V1/guest-carts/' . $this->session->get('cart_id'));
        }else {
            $request = $this->buildRequest('GET', 'V1/carts/mine', $this->token->getAttribute('bearerToken'));
        }
        return $request;
    }

    /**
     * @return Request
     */
    public function getCartItemRequest()
    {
        if($this->token instanceof AnonymousToken){
            $request = $this->buildRequest('GET', 'V1/guest-carts/' . $this->session->get('cart_id') . '/items');
        }else {
            $request = $this->buildRequest('GET', 'V1/carts/mine/items', $this->token->getAttribute('bearerToken'));
        }

        return $request;
    }

    /**
     * @return Request
     */
    public function getPaymentInformationRequest()
    {
        if($this->token instanceof AnonymousToken){
            $request = $this->buildRequest('GET', 'V1/guest-carts/' . $this->session->get('cart_id') . '/payment-information');
        }else {
            $request = $this->buildRequest('GET', 'V1/carts/mine/payment-information', $this->token->getAttribute('bearerToken'));
        }
        return $request;
    }

    /**
     * @param $productData
     * @return Request
     */
    public function getAddToCartRequest($productData)
    {
        if($this->token instanceof AnonymousToken){
            $cartId = $this->session->get('cart_id');
            $data = $productData['cart_item'];
            $data['quote_id'] = $cartId;
            unset($productData);
            $productData = ['cartItem' => $data];
            $addToCartRequest = $this->buildRequest('POST', '/V1/guest-carts/' . $cartId . '/items', false, $productData);
        }else {
            $addToCartRequest = $this->buildRequest('POST', 'V1/carts/mine/item',$this->token->getAttribute('bearerToken'), $productData);
        }
        return $addToCartRequest;
    }

    /**
     * @param $action
     * @param $uri
     * @param array $payload
     * @param bool $token
     * @return Request
     */
    private function buildRequest($action, $uri, $token = false, $payload = []) : Request
    {
        $headers = [
            "Content-Type" => "application/json",
        ];
        if($token !== false){
            $headers["Authorization"] = "Bearer " . $token;
        }

        if(is_array($payload)){
            $payload = \GuzzleHttp\json_encode($payload);
        }

        $request = new Request(
            $action,
            $this->shopUrl . 'rest/' . $uri,
            $headers,
            $payload
        );
        return $request;
    }

    /**
     *
     */
    private function createGuestCart()
    {
        $request = $this->buildRequest('POST', 'V1/guest-carts');
        $response = (new Client())->send($request);
        $cartId = \GuzzleHttp\json_decode($response->getBody()->getContents());
        $this->session->set('cart_id', $cartId);
    }

    public function getShippingAddressRequest()
    {
        if($this->token instanceof AnonymousToken){
            return false;
        }else {
            $request = $this->buildRequest('GET', 'V1/customers/me/shippingAddress',$this->token->getAttribute('bearerToken'));
        }
        return $request;
    }

    public function getAdminTokenRequest()
    {
        $userData = \json_encode(
            [
                'username' => $this->adminUser,
                'password' => $this->adminPassword
            ]
        );
        $request = $this->buildRequest('POST', 'V1/integration/admin/token',false, $userData);
        return $request;
    }

    public function getAddressMetadataRequest($bearerToken)
    {
        $request = $this->buildRequest('GET', 'V1/attributeMetadata/customerAddress',$bearerToken);
        return $request;
    }

    public function getCategoriesRequest($bearerToken)
    {
        $request = $this->buildRequest('GET', 'V1/categories', $bearerToken);
        return $request;
    }

    public function getCategoryRequest($bearerToken, $categoryId)
    {
        $request = $this->buildRequest('GET', 'V1/categories/'.$categoryId . '/products', $bearerToken);
        return $request;
    }

    public function getProductDataRequest($bearerToken, $sku)
    {
        $request = $this->buildRequest('GET', 'V1/products/'. $sku, $bearerToken);
        return $request;
    }

    public function getAttributeValueRequest($bearerToken, $attributeId)
    {
        $request = $this->buildRequest('GET', 'V1/products/attributes/'. $attributeId .'/options', $bearerToken);
        return $request;
    }

    public function getCache()
    {
        return $this->cacheAdapter;
    }
}