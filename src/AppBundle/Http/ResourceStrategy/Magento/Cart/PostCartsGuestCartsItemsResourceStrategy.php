<?php
namespace AppBundle\Http\ResourceResources\Magento\Cart;

use AppBundle\Http\RequestResources\AbstractResourceStrategy;
use AppBundle\Http\RequestResources\PostRequestInterface;
use AppBundle\Http\RequestResources\ResourceStrategyInterface;

class PostCartsGuestCartsItemsResourceStrategy
    extends AbstractResourceStrategy
    implements
        ResourceStrategyInterface,
        PostRequestInterface
{
    /**
     * @var string resource target uri
     */
    protected $uri = "V1/guest-carts/:cartId/items";

    /**
     * @var string Request Method
     */
    protected $method = "POST";

    /**
     * @var string
     */
    private $body;

    /**
     * @return string
     */
    public function request() : string
    {
        // TODO: Implement request() method.
    }

    /**
     * Add body for post request.
     *
     * @param string $payload
     *
     * @return mixed
     */
    public function setBody(string $payload)
    {
        $this->body = $payload;
        return $this;
    }

    /**
     * @return bool checks for resource support for given request
     */
    public function supports() : bool
    {
        // TODO: Implement supports() method.
    }
}