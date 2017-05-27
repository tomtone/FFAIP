<?php
namespace AppBundle\Http\Cart;

use AppBundle\Service\Scope;
use GuzzleHttp\Psr7\Request;

/**
 * Class CartItemRequest
 * @package AppBundle\Http\Cart
 */
class CartItemRequest extends Request
{
    /**
     * @var array
     */
    private $uris = [
        Scope::URI_TYPE_GUEST => 'V1/guest-carts/:cartId/items',
        Scope::URI_TYPE_CUSTOMER => 'V1/carts/mine/items'
    ];

    /**
     * CartItemRequest constructor.
     * 
     * @param Scope $scopeContext
     */
    public function __construct(Scope $scopeContext)
    {
        $headers = [
            "Content-Type" => "application/json",
        ];
        $uri = $scopeContext->prepareUri($this->uris);
        $headers = $scopeContext->extendHeaders($headers);
        parent::__construct('GET', $uri, $headers);
    }
}