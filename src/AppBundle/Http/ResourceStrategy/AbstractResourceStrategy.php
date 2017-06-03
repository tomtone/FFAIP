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
        return $resource == $this->resourceName;
    }

    public function getScope()
    {
        return $this->scopeContext;
    }
}
