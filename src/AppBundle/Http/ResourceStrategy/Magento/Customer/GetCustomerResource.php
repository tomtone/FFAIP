<?php
namespace AppBundle\Http\ResourceStrategy\Magento\Customer;

use AppBundle\Http\ResourceStrategy\AbstractCustomerResourceStrategy;
use AppBundle\Http\ResourceStrategy\ResourceStrategyInterface;

class GetCustomerResource
    extends AbstractCustomerResourceStrategy
    implements
    ResourceStrategyInterface
{
    /**
     * @var string
     */
    protected $resourceName = "customer_customer";

    /**
     * @var string resource target uri
     */
    protected $uri = "V1/customers/me";

    /**
     * @var string Request Method
     */
    protected $method = "GET";
}
