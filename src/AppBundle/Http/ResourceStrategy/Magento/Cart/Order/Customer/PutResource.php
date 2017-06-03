<?php
namespace AppBundle\Http\ResourceStrategy\Magento\Cart\Order\Customer;

use AppBundle\Http\ResourceStrategy\AbstractCustomerResourceStrategy;
use AppBundle\Http\ResourceStrategy\ResourceStrategyInterface;
use AppBundle\Http\ResourceStrategy\PutRequestInterface;

class PutResource
    extends AbstractCustomerResourceStrategy
    implements
    ResourceStrategyInterface,
    PutRequestInterface

{
    /**
     * @var string resource target uri
     */
    protected $uri = "V1/carts/mine/order";

    /**
     * @var string Request Method
     */
    protected $method = "PUT";

    /**
     * @var string
     */
    protected $resourceName = "cart_order_put";

    public function getBody(array $args) {
        return $args;
    }
}
