<?php
namespace AppBundle\Http\ResourceStrategy\Fixture\Catalog\Categories;

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
     * @param null $args
     * @return array|string
     */
    public function request($args = null) : array
    {
       $data = $this->getFileContent('catalog/categories.json');
       return $data['children_data'];
    }
}