<?php
namespace AppBundle\Http\RequestResources\Magento\Cart;

use AppBundle\Http\RequestResources\AbstractResourceStrategy;
use AppBundle\Http\RequestResources\ResourceStrategyInterface;

class PostCartsMineItemsRequestStrategy
    extends AbstractResourceStrategy
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