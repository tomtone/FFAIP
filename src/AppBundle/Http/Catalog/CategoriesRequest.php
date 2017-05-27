<?php
namespace AppBundle\Http\Catalog;

use AppBundle\Service\Scope;
use GuzzleHttp\Psr7\Request;

/**
 * Class CategoriesRequest
 * @package AppBundle\Http\Catalog
 */
class CategoriesRequest extends Request
{
    /**
     * @var array
     */
    private $uris = [
        Scope::URI_TYPE_GLOBAL => 'V1/categories'
    ];

    /**
     * CategoriesRequest constructor.
     * 
     * @param Scope $scopeContext
     * @param \Psr\Http\Message\UriInterface|string $adminToken
     */
    public function __construct(Scope $scopeContext, $adminToken)
    {
        $headers = [
            "Content-Type" => "application/json",
        ];
        $uri = $scopeContext->prepareUri($this->uris);
        $headers = $scopeContext->extendHeaders($headers, $adminToken);
        parent::__construct('GET', $uri, $headers);
    }
}