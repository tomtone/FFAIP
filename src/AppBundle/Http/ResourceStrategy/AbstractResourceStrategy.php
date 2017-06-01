<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 01.06.2017
 * Time: 19:57
 */

namespace AppBundle\Http\RequestResources;


use AppBundle\Service\Scope;

class AbstractResourceStrategy
{
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
     * AbstractResourceStrategy constructor.
     * @param Scope $scopeContext
     */
    public function __construct(Scope $scopeContext)
    {
        $this->scopeContext = $scopeContext;
    }
}