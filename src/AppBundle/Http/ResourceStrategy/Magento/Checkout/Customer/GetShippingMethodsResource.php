<?php
namespace AppBundle\Http\ResourceStrategy\Magento\Checkout\Customer;

use AppBundle\Http\ResourceStrategy\AbstractCustomerResourceStrategy;
use AppBundle\Http\ResourceStrategy\ResourceStrategyInterface;
use AppBundle\Http\ResourceStrategy\PostRequestInterface;

class GetShippingMethodsResource
    extends AbstractCustomerResourceStrategy
    implements
    ResourceStrategyInterface,
    PostRequestInterface
{
    /**
     * @var string resource target uri
     */
    protected $uri = "V1/carts/mine/estimate-shipping-methods-by-address-id";

    /**
     * @var string Request Method
     */
    protected $method = "POST";

    /**
     * @var string
     */
    protected $resourceName = "checkout_shipping_methods";

    public function getBody(array $args) {
        return $args;
    }
}
