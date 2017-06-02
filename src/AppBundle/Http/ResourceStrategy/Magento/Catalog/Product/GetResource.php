<?php
namespace AppBundle\Http\ResourceStrategy\Magento\Catalog\Product;

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
    protected $uri = "V1/products/:sku";

    /**
     * @var string Request Method
     */
    protected $method = "GET";

    /**
     * @var string
     */
    protected $resourceName = "catalog_product_view";

    /**
     * @param null $args
     * @return array|string
     */
    public function request($args = null) : array
    {
        $productSku = reset($args);
        $uri = str_replace(':sku', $productSku, $this->uri);
        $uri = $this->scopeContext->prepareUri(['global' => $uri]);

        $request = new Request('GET', $uri, $this->header);
        $client = new Client();
        $response = $client->send($request);
        $response = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

        return $response;
    }

    /**
     * @param $resource
     * @return bool checks for resource support for given request
     */
    public function supports($resource) : bool
    {
        return $this->resourceName == $resource;
    }

}