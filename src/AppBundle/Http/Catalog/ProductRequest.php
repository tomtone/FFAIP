<?php
namespace AppBundle\Http\Catalog;

use AppBundle\Service\Scope;
use GuzzleHttp\Psr7\Request;

/**
 * Class ProductRequest
 * @package AppBundle\Http\Catalog
 */
class ProductRequest extends Request
{
    /**
     * @var array
     */
    private $uris = [
        Scope::URI_TYPE_GLOBAL => 'V1/products/:sku'
    ];

    /**
     * ProductRequest constructor.
     * 
     * @param Scope $scopeContext
     * @param \Psr\Http\Message\UriInterface|string $sku
     * @param array $adminToken
     */
    public function __construct(Scope $scopeContext, $sku, $adminToken)
    {
        $headers = [
            "Content-Type" => "application/json",
        ];
        $uri = $scopeContext->prepareUri($this->uris);
        $uri = str_replace(':sku', $sku, $uri);
        $headers = $scopeContext->extendHeaders($headers, $adminToken);
        parent::__construct('GET', $uri, $headers);
    }
}