<?php
namespace AppBundle\Http\ResourceStrategy\Fixture\Catalog\Categories;

use AppBundle\Http\ResourceStrategy\Fixture\AbstractFixtureResourceStrategy;
use AppBundle\Http\ResourceStrategy\ResourceStrategyInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class GetListResource
    extends AbstractFixtureResourceStrategy
    implements
    ResourceStrategyInterface
{
    /**
     * @var string resource target uri
     */
    protected $uri = "V1/categories/:categoryId/products";

    /**
     * @var string Request Method
     */
    protected $method = "GET";

    /**
     * @var string resource
     */
    protected $resourceName = "catalog_category_view";

    /**
     * @param array|null $args
     *
     * @return array
     */
    public function request($args = null) : array
    {
        $data = $this->getFileContent('catalog/categoryProducts.json');
        foreach ($data as $key => $product) {
            $product['product'] = $this->resourceGenerator->generate('catalog_product_view', $product['sku']);
            $data[$key] = $product;
        }
        return $data;
    }
}