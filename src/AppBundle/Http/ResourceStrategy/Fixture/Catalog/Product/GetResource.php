<?php
namespace AppBundle\Http\ResourceStrategy\Fixture\Catalog\Product;

use AppBundle\Http\ResourceStrategy\Fixture\AbstractFixtureResourceStrategy;
use AppBundle\Http\ResourceStrategy\ResourceStrategyInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class GetResource
    extends AbstractFixtureResourceStrategy
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
        $data = $this->getFileContent('catalog/product/' . $productSku . '.json');
        return $data;
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