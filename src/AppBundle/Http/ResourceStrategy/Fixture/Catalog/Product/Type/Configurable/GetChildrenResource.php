<?php
namespace AppBundle\Http\ResourceStrategy\Fixture\Catalog\Product\Type\Configurable;

use AppBundle\Http\ResourceStrategy\Fixture\AbstractFixtureResourceStrategy;
use AppBundle\Http\ResourceStrategy\ResourceStrategyInterface;

class GetChildrenResource
    extends AbstractFixtureResourceStrategy
    implements
    ResourceStrategyInterface
{
    /**
     * @var string resource target uri
     */
    protected $uri = "/V1/configurable-products/:sku/children";

    /**
     * @var string Request Method
     */
    protected $method = "GET";

    /**
     * @var string
     */
    protected $resourceName = "catalog_product_type_configurable_children";

    /**
     * @param null $args
     * @return array|string
     */
    public function request($args = null) : array
    {
        $data = $this->getFileContent('catalog/product/type/configurable/children.json');
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