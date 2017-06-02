<?php
namespace AppBundle\Http\ResourceStrategy\Fixture\Cart\Items\Guest;

use AppBundle\Http\ResourceStrategy\Fixture\AbstractFixtureResourceStrategy;
use AppBundle\Http\ResourceStrategy\PostRequestInterface;
use AppBundle\Http\ResourceStrategy\ResourceStrategyInterface;

class PostResource
    extends AbstractFixtureResourceStrategy
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
     * @param $resource
     * @return bool checks for resource support for given request
     */
    public function supports($resource) : bool
    {
        return false;
    }
}