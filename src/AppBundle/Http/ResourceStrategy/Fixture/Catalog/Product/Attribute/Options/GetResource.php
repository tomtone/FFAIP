<?php
namespace AppBundle\Http\ResourceStrategy\Fixture\Catalog\Product\Attribute\Options;

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
    protected $uri = "V1/products/attributes/:attributeId/options";

    /**
     * @var string Request Method
     */
    protected $method = "GET";

    /**
     * @var string
     */
    protected $resourceName = "catalog_product_attribute";

    /**
     * @param null $args
     * @return array|string
     */
    public function request($args = null) : array
    {
        $attributeId = reset($args);
        $data = $this->getFileContent('catalog/product/attributes/' . $attributeId . '.json');
        return $data;
    }
}