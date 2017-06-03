<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 01.06.2017
 * Time: 19:57
 */

namespace AppBundle\Http\ResourceStrategy;


use AppBundle\Http\MagentoResourceGenerator;
use AppBundle\Service\Scope;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class AbstractResourceStrategy
{
    /**
     * @var string resource
     */
    protected $resourceName = "";

    /**
     * @var string resource target uri
     */
    protected $uri;

    /**
     * @var string Request Method
     */
    protected $method = "GET";

    /**
     * @var array additional headers
     */
    protected $header = [
        "Content-Type" => "application/json",
    ];

    /**
     * @var Scope scope context to retrieve token
     */
    protected $scopeContext;

    /**
     * @var MagentoResourceGenerator
     */
    protected $resourceGenerator;

    /**
     * AbstractResourceStrategy constructor.
     * @param Scope $scopeContext
     * @param MagentoResourceGenerator $resourceGenerator
     */
    public function __construct(Scope $scopeContext, MagentoResourceGenerator $resourceGenerator)
    {
        $this->scopeContext = $scopeContext;
        $this->resourceGenerator = $resourceGenerator;
    }

    /**
     * @param $resource
     * @return bool checks for resource support for given request
     */
    public function supports($resource) : bool
    {
        $resourceMatches = $resource == $this->resourceName;
        if (!$resourceMatches) {
            return false;
        }
        return $this->getScope()->isGuest() == $this->isGuestResource();
    }

    /**
     * @param null $args
     * @return array|string
     */
    public function request($args = null) : array
    {
        $uri = $this->scopeContext->prepareUri(['global' => $this->uri]);
        $request = new Request('GET', $uri, $this->header);
        $client = new Client();
        $response = $client->send($request);
        $response = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

        return $response;
    }

    /**
     * getScope
     *
     */
    public function getScope()
    {
        return $this->scopeContext;
    }

    /**
     * isGuestResource
     *
     * magic Guest vs. Customer check
     * class path should contain Guest somewhere in classname
     */
    public function isGuestResource()
    {
        $className = get_class($this);
        return strpos($className, 'Guest') !== false;
    }
}
