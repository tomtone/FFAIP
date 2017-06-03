<?php
namespace AppBundle\Http\Sales;

use AppBundle\Service\Scope;
use GuzzleHttp\Psr7\Request;

/**
 * Class PaymentInformationRequest
 * @package AppBundle\Http\Checkout
 */
class OrderRequest extends Request
{
    /**
     * @var array
     */
    private $uris = [
        Scope::URI_TYPE_GLOBAL => 'V1/orders'
    ];

    /**
     * PaymentInformationRequest constructor.
     *
     * @param Scope $scopeContext
     */
    public function __construct(Scope $scopeContext, $bearerToken)
    {
        $headers = [
            "Content-Type" => "application/json",
        ];
        $uri = $scopeContext->prepareUri($this->uris);
        $uri = $this->prepareSearchRequest($uri, $scopeContext->getCustomerId());
        $headers = $scopeContext->extendHeaders($headers, $bearerToken);
        parent::__construct('GET', $uri, $headers);
    }

    private function prepareSearchRequest($uri, $customerId)
    {
        $searchCriteria = [
            'searchCriteria' => [
                'filterGroups' => [
                    [
                        'filters' => [
                            [
                                'field' => 'customer_id',
                                'value' => $customerId
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $query = http_build_query($searchCriteria);

        return $uri . '?' . $query;
    }
}