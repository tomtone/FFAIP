<?php
namespace AppBundle\Http\Checkout;

use AppBundle\Service\Scope;
use GuzzleHttp\Psr7\Request;

/**
 * Class PaymentInformationRequest
 * @package AppBundle\Http\Checkout
 */
class PaymentInformationRequest extends Request
{
    /**
     * @var array
     */
    private $uris = [
        Scope::URI_TYPE_GUEST => 'V1/guest-carts/:cartId/payment-information',
        Scope::URI_TYPE_CUSTOMER => 'V1/carts/mine/payment-information'
    ];

    /**
     * PaymentInformationRequest constructor.
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