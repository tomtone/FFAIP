<?php
namespace AppBundle\Http;


use AppBundle\Entity\Address;
use AppBundle\Http\Cart\AddToCartRequest;
use AppBundle\Http\Cart\CartItemRequest;
use AppBundle\Http\Cart\CartRequest;
use AppBundle\Http\Catalog\CategoryRequest;
use AppBundle\Http\Catalog\ProductRequest;
use AppBundle\Http\Catalog\AttributeRequest;
use AppBundle\Http\Catalog\CategoriesRequest;
use AppBundle\Http\Checkout\PaymentInformationRequest;
use AppBundle\Service\Scope;
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
     * @var Scope
     */
    private $scopeContext;

    /**
     * RequestFactory constructor.
     *
     * @param string $shopUrl
     * @param string $adminUser
     * @param string $adminPassword
     * @param TokenStorage $tokenStorage
     * @param Session $session
     * @param CacheItemPoolInterface $cacheAdapter
     * @param Scope $scopeContext
     */
    public function __construct(
        string $shopUrl,
        string $adminUser,
        string $adminPassword,
        TokenStorage $tokenStorage,
        Session $session,
        CacheItemPoolInterface $cacheAdapter,
        Scope $scopeContext
    )
    {
        $this->shopUrl = $shopUrl;
        $this->adminUser = $adminUser;
        $this->adminPassword = $adminPassword;
        $this->tokenStorage = $tokenStorage;
        $this->token = $tokenStorage->getToken();
        $this->cacheAdapter = $cacheAdapter;
        $this->session = $session;

        $this->scopeContext = $scopeContext;

        if ($this->session->has('cart_id')) {
            if ($scopeContext->isGuest()) {
                $this->createGuestCart();
            } else {
                $this->fetchQuoteId();
            }
        }
    }

    /**
     * @return Request
     */
    public function getCartRequest()
    {
        return new CartRequest($this->scopeContext);
    }

    /**
     * @return Request
     */
    public function getCartItemRequest()
    {
        return new CartItemRequest($this->scopeContext);
    }

    /**
     * @return Request
     */
    public function getPaymentInformationRequest()
    {
        return new PaymentInformationRequest($this->scopeContext);
    }

    /**
     * @param $productData
     * @return Request
     */
    public function getAddToCartRequest($productData)
    {
        return new AddToCartRequest($this->scopeContext, $productData);
    }

    /**
     * @param $itemId
     * @return Request
     */
    public function removeItemFromCartRequest($itemId)
    {
        if ($scopeContext->isGuest()) {
            // TODO
        } else {
            $addToCartRequest = $this->buildRequest('DELETE', 'V1/carts/mine/items/' . $itemId, $this->token->getAttribute('bearerToken'));
        }
        return $addToCartRequest;
    }

    /**
     * @param $itemId
     * @param $qty
     * @return Request
     */
    public function updateItemQtyRequest($quoteId, $itemId, $qty)
    {
        if ($scopeContext->isGuest()) {
            // TODO
        } else {
            $payload = [
                'cartItem' => [
                    'qty' => $qty,
                    'quoteId' => $quoteId,
                    'itemId' => $itemId
                ]
            ];
            $addToCartRequest = $this->buildRequest('POST', 'V1/carts/mine/items/', $this->token->getAttribute('bearerToken'), $payload);
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
        if ($token !== false) {
            $headers["Authorization"] = "Bearer " . $token;
        }

        if (is_array($payload)) {
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

    private function fetchQuoteId()
    {
        $request = $this->getCartRequest();
        $response = (new Client())->send($request);
        $response = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        $this->session->set('cart_id', $response['id']);
    }

    public function getShippingAddressRequest()
    {
        if ($scopeContext->isGuest()) {
            return false;
        } else {
            $request = $this->buildRequest('GET', 'V1/customers/me/shippingAddress', $this->token->getAttribute('bearerToken'));
        }
        return $request;
    }

    public function getAdminTokenRequest()
    {
        return new AdminTokenRequest($this->scopeContext, $this->adminUser, $this->adminPassword);
    }

    public function getAddressMetadataRequest($bearerToken)
    {
        $request = $this->buildRequest('GET', 'V1/attributeMetadata/customerAddress', $bearerToken);
        return $request;
    }

    public function getCategoriesRequest($bearerToken)
    {
        return new CategoriesRequest($this->scopeContext, $bearerToken);
    }

    public function getCategoryRequest($bearerToken, $categoryId)
    {
        return new CategoryRequest($this->scopeContext, $categoryId, $bearerToken);
    }

    public function getProductDataRequest($bearerToken, $sku)
    {
        return new ProductRequest($this->scopeContext, $sku, $bearerToken);
    }

    public function getAttributeValueRequest($bearerToken, $attributeId)
    {
        return new AttributeRequest($this->scopeContext, $attributeId, $bearerToken);
    }

    public function getCache()
    {
        return $this->cacheAdapter;
    }

    public function prepareSaveAddressRequest($address)
    {
        $shippingAddress = (new Address($address))->toArray();
        $billingAddress = (new Address($address, Address::ADDRESS_TYPE_BILLING))->toArray();
        $addressPayload = [
            'addressInformation' => [
                'shipping_address' => $shippingAddress,
                'billing_address' => $billingAddress,
                'shipping_method_code' => 'flatrate',   # need to be setted to default
                'shipping_carrier_code' => 'flatrate'   # need to be setted to default
            ]
        ];
        /* not really sure why i have to do this... [BEGIN] */
        if ($scopeContext->isGuest()) {
            $cartId = $this->session->get('cart_id');
            $request = $this->buildRequest('POST', 'V1/guest-carts/' . $cartId . '/shipping-information', false, $addressPayload);
        } else {
            $request = $this->buildRequest('POST', 'V1/carts/mine/shipping-information', $this->token->getAttribute('bearerToken'), $addressPayload);
        }
        $client = new Client();
        $client->send($request);
        /* [END] */
        return $addressPayload;
    }

    public function placeOrderRequest()
    {
        $addressPayload = $this->session->get('cart_request');
        dump($addressPayload);
        if ($scopeContext->isGuest()) {
            $cartId = $this->session->get('cart_id');
            $request = $this->buildRequest('POST', 'V1/guest-carts/' . $cartId . '/shipping-information', false, $addressPayload);
        } else {
            $request = $this->buildRequest('POST', 'V1/carts/mine/shipping-information', $this->token->getAttribute('bearerToken'), $addressPayload);
        }
        $client = new Client();
        $response = $client->send($request);

        $addressPayload = \GuzzleHttp\json_encode($addressPayload, JSON_FORCE_OBJECT);

        if ($scopeContext->isGuest()) {
            $cartId = $this->session->get('cart_id');
            $request = $this->buildRequest('PUT', 'V1/guest-carts/' . $cartId . '/order', false, $addressPayload);
        } else {
            $request = $this->buildRequest('PUT', 'V1/carts/mine/order', $this->token->getAttribute('bearerToken'), $addressPayload);
        }
        return $request;
    }

    public function getSession()
    {
        return $this->session;
    }

    public function getShippingMethodsRequest()
    {
        if ($scopeContext->isGuest()) {
            $cartId = $this->session->get('cart_id');
            $request = $this->buildRequest('GET', 'V1/guest-carts/' . $cartId . '/shipping-methods');
        } else {
            $request = $this->buildRequest('GET', 'V1/carts/mine/shipping-methods', $this->token->getAttribute('bearerToken'));
        }
        return $request;
    }

    public function addPaymentMethodRequest($payment)
    {
        $paymentPayload = [
            'method' => ['method' => $payment['payment']]
        ];
        if ($scopeContext->isGuest()) {
            $cartId = $this->session->get('cart_id');
            $request = $this->buildRequest('PUT', 'V1/guest-carts/' . $cartId . '/selected-payment-method', false, $paymentPayload);
        } else {
            $request = $this->buildRequest('PUT', 'V1/carts/mine/selected-payment-method', $this->token->getAttribute('bearerToken'), $paymentPayload);
        }
        return $request;
    }
}
