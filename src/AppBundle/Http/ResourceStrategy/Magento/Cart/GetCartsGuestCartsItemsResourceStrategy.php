<?php
namespace AppBundle\Http\ResourceResources\Magento\Cart;

use AppBundle\Http\RequestResources\AbstractResourceStrategy;
use AppBundle\Http\RequestResources\ResourceStrategyInterface;

class GetCartsGuestCartsItemsResourceStrategy
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