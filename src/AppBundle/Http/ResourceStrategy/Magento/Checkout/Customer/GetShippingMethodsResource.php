<?php
namespace AppBundle\Http\ResourceStrategy\Magento\Checkout\Customer;

use AppBundle\Http\ResourceStrategy\AbstractCustomerResourceStrategy;
use AppBundle\Http\ResourceStrategy\ResourceStrategyInterface;

class GetShippingMethodsResource
    extends AbstractCustomerResourceStrategy
    implements
    ResourceStrategyInterface
{
    /**
     * @var string resource target uri
     */
    protected $uri = "V1/carts/mine/shipping-methods";

    /**
     * @var string Request Method
     */
    protected $method = "GET";

    /**
     * @var string
     */
    protected $resourceName = "checkout_shipping_methods";
}
