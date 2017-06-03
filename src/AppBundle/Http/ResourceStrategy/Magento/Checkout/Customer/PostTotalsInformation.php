<?php
namespace AppBundle\Http\ResourceStrategy\Magento\Checkout\Customer;

use AppBundle\Http\ResourceStrategy\AbstractCustomerResourceStrategy;
use AppBundle\Http\ResourceStrategy\PostRequestInterface;
use AppBundle\Http\ResourceStrategy\ResourceStrategyInterface;

class PostTotalsInformation
    extends AbstractCustomerResourceStrategy
    implements
    PostRequestInterface,
    ResourceStrategyInterface
{
    /**
     * @var string resource target uri
     */
    /* protected $uri = "V1/carts/mine/totals-information"; */
    protected $uri = "V1/carts/mine/shipping-information";

    /**
     * @var string Request Method
     */
    protected $method = "POST";

    /**
     * @var string
     */
    protected $resourceName = "checkout_totals_information";

    public function getBody(array $args) {
        return $args;
    }
}
