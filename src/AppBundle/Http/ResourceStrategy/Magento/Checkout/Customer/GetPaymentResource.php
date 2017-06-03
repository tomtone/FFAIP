<?php
namespace AppBundle\Http\ResourceStrategy\Magento\Checkout\Customer;

use AppBundle\Http\ResourceStrategy\AbstractCustomerResourceStrategy;
use AppBundle\Http\ResourceStrategy\ResourceStrategyInterface;

class GetPaymentResource
    extends AbstractCustomerResourceStrategy
    implements
    ResourceStrategyInterface
{
    /**
     * @var string resource target uri
     */
    protected $uri = "V1/carts/mine/payment-information";

    /**
     * @var string Request Method
     */
    protected $method = "GET";

    /**
     * @var string
     */
    protected $resourceName = "checkout_payment_methods";
}
