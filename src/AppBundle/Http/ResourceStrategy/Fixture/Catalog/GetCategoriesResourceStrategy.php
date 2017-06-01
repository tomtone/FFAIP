<?php
namespace AppBundle\Http\RequestResources\Fixture\Catalog;

use AppBundle\Http\RequestResources\AbstractResourceStrategy;
use AppBundle\Http\RequestResources\ResourceStrategyInterface;

class GetCategoriesResourceStrategy
    extends AbstractResourceStrategy
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
     * @return string
     */
    public function request() : string
    {
        // TODO: Implement request() method.
    }

    /**
     * @return bool checks for resource support for given request
     */
    public function supports() : bool
    {
        // TODO: Implement supports() method.
    }

}