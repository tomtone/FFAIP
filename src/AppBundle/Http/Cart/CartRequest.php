<?php
namespace AppBundle\Http\Cart;

use AppBundle\Service\Scope;
use GuzzleHttp\Psr7\Request;

class CartRequest extends Request
{
    private $uris = [
        Scope::URI_TYPE_GUEST => 'V1/guest-carts/:cartId',
        Scope::URI_TYPE_CUSTOMER => 'V1/carts/mine'
    ];
    
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