<?php
namespace AppBundle\Http\Cart;

use AppBundle\Service\Scope;
use GuzzleHttp\Psr7\Request;

/**
 * Class AddToCartRequest
 * @package AppBundle\Http\Cart
 */
class AddToCartRequest extends Request
{
    /**
     * @var array
     */
    private $uris = [
        Scope::URI_TYPE_GUEST => 'V1/guest-carts/:cartId/items',
        Scope::URI_TYPE_CUSTOMER => 'V1/carts/mine/items'
    ];

    /**
     * AddToCartRequest constructor.
     * 
     * @param Scope $scopeContext
     * @param \Psr\Http\Message\UriInterface|string $payload
     */
    public function __construct(Scope $scopeContext, $payload)
    {
        $headers = [
            "Content-Type" => "application/json",
        ];
        $uri = $scopeContext->prepareUri($this->uris);
        $headers = $scopeContext->extendHeaders($headers);
        $payload = $scopeContext->preparePayload($payload);
        parent::__construct('POST', $uri, $headers, $payload);
    }
}