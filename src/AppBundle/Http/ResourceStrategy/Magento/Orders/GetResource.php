<?php
namespace AppBundle\Http\ResourceStrategy\Magento\Orders;

use AppBundle\Http\ResourceStrategy\AbstractAdminResourceStrategy;
use AppBundle\Http\ResourceStrategy\ResourceStrategyInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class GetResource
    extends AbstractAdminResourceStrategy
    implements
    ResourceStrategyInterface
{
    /**
     * @var string resource target uri
     */
    protected $uri = "V1/orders";

    /**
     * @var string Request Method
     */
    protected $method = "GET";

    /**
     * @var string
     */
    protected $resourceName = "sales_order";

    /**
     * @param null $args
     * @return array|string
     */
    public function request($args = null) : array
    {
        $orderId = reset($args);
        $uri = $this->scopeContext->prepareUri(['global' => $this->uri]);
        if($orderId === false) {
            $uri = $this->prepareSearchRequest($uri, $this->scopeContext->getCustomerId());
        }else{
            $uri .= '/' . $orderId;
        }
        $request = new Request('GET', $uri, $this->header);
        $client = new Client();
        $response = $client->send($request);
        $response = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

        return $response;
    }

    /**
     * @param $uri
     * @param $customerId
     * @return string
     */
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