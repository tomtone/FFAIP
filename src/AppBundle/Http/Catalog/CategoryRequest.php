<?php
namespace AppBundle\Http\Catalog;

use AppBundle\Service\Scope;
use GuzzleHttp\Psr7\Request;

/**
 * Class CategoryRequest
 * @package AppBundle\Http\Catalog
 */
class CategoryRequest extends Request
{
    /**
     * @var array
     */
    private $uris = [
        Scope::URI_TYPE_GLOBAL => 'V1/categories/:categoryId/products',
        Scope::URI_TYPE_CUSTOMER => 'V1/carts/mine'
    ];

    /**
     * CategoryRequest constructor.
     * 
     * @param Scope $scopeContext
     * @param \Psr\Http\Message\UriInterface|string $categoryId
     * @param array $adminToken
     */
    public function __construct(Scope $scopeContext, $categoryId, $adminToken)
    {
        $headers = [
            "Content-Type" => "application/json",
        ];
        $uri = $scopeContext->prepareUri($this->uris);
        $uri = str_replace(':categoryId', $categoryId, $uri);
        $headers = $scopeContext->extendHeaders($headers, $adminToken);
        parent::__construct('GET', $uri, $headers);
    }
}