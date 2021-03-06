<?php
namespace AppBundle\Http\ResourceStrategy\Magento\Cart\Items\Customer;

use AppBundle\Http\ResourceStrategy\AbstractResourceStrategy;
use AppBundle\Http\ResourceStrategy\PostRequestInterface;
use AppBundle\Http\ResourceStrategy\ResourceStrategyInterface;

class PostRequest
    extends AbstractResourceStrategy
    implements
        ResourceStrategyInterface,
        PostRequestInterface
{
    /**
     * @var string resource target uri
     */
    protected $uri = "V1/carts/mine/items";

    /**
     * @var string Request Method
     */
    protected $method = "POST";

    /**
     * @var string
     */
    private $body;

    /**
     * @param null $args
     * @return array|string
     */
    public function request($args = null) : array
    {
        // TODO: Implement request() method.
    }

    /**
     * Add body for post request.
     *
     * @param array $args
     *
     * @return mixed
     */
    public function getBody(array $args)
    {
        return $args;
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
