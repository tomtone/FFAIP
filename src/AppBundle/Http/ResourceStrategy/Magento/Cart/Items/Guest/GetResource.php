<?php
namespace AppBundle\Http\ResourceStrategy\Magento\Cart\Items\Guest;

use AppBundle\Http\ResourceStrategy\AbstractResourceStrategy;
use AppBundle\Http\ResourceStrategy\ResourceStrategyInterface;

class GetResource
    extends AbstractResourceStrategy
    implements
        ResourceStrategyInterface
{
    /**
     * @var string resource target uri
     */
    protected $uri = "V1/guest-carts/:cartId/items";

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