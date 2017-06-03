<?php
namespace AppBundle\Http\ResourceStrategy\Magento\Catalog\Categories;

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
    protected $uri = "V1/categories";

    /**
     * @var string Request Method
     */
    protected $method = "GET";

    /**
     * @var string resource
     */
    protected $resourceName = "catalog_category_list";

    /**
     * @var string
     */
    protected $adminRequest = true;


    /**
     * @param null $args
     * @return array|string
     */
    public function request($args = null) : array
    {
        $request = new Request($this->method, $this->scopeContext->prepareUri(['global' => $this->uri]), $this->header);
        $client = new Client();
        $response = $client->send($request);

        $response = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

        return (isset($response['children_data']))? $response['children_data'] : [];
    }
}
