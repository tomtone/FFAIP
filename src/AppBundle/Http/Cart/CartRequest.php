<?php
namespace AppBundle\Http\Cart;

use AppBundle\Service\Scope;
use GuzzleHttp\Psr7\Request;

/**
 * Class CartRequest
 * @package AppBundle\Http\Cart
 */
class CartRequest extends Request
{
    /**
     * @var array
     */
    private $uris = [
        Scope::URI_TYPE_GUEST => 'V1/guest-carts/:cartId',
        Scope::URI_TYPE_CUSTOMER => 'V1/carts/mine'
    ];

    /**
     * CartRequest constructor.
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
