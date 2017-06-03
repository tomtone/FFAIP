<?php
namespace AppBundle\Http\ResourceStrategy\Magento\Customer;

use AppBundle\Http\ResourceStrategy\AbstractCustomerResourceStrategy;
use AppBundle\Http\ResourceStrategy\ResourceStrategyInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class GetCustomerResource
    extends AbstractCustomerResourceStrategy
    implements
    ResourceStrategyInterface
{
    /**
     * @var string
     */
    protected $resourceName = "customer_customer";

    /**
     * @var string resource target uri
     */
    protected $uri = "V1/customers/me";

    /**
     * @var string Request Method
     */
    protected $method = "GET";

    /**
     * @param null $args
     * @return array|string
     */
    public function request($args = null) : array
    {
        $uri = $this->scopeContext->prepareUri(['global' => $this->uri]);
        $request = new Request('GET', $uri, $this->header);
        $client = new Client();
        $response = $client->send($request);
        $response = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

        return $response;
    }
}
