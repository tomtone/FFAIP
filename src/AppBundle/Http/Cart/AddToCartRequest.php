<?php
namespace AppBundle\Http\Cart;

use AppBundle\Service\Scope;
use GuzzleHttp\Psr7\Request;

class AddToCartRequest extends Request
{
    private $uris = [
        Scope::URI_TYPE_GUEST => 'V1/guest-carts/:cartId/items',
        Scope::URI_TYPE_CUSTOMER => 'V1/carts/mine/items'
    ];
    
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