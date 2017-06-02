<?php
namespace AppBundle\Http\ResourceStrategy\Fixture\Cart\Items\Customer;

use AppBundle\Http\ResourceStrategy\Fixture\AbstractFixtureResourceStrategy;
use AppBundle\Http\ResourceStrategy\ResourceStrategyInterface;

class GetResource
    extends AbstractFixtureResourceStrategy
    implements
        ResourceStrategyInterface
{
    /**
     * @var string resource target uri
     */
    protected $uri = "V1/carts/mine/items";

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
        // TODO: Implement request() method.
    }

    /**
     * @param $resource
     * @return bool checks for resource support for given request
     */
    public function supports($resource) : bool 
    {
        return false;
    }
}