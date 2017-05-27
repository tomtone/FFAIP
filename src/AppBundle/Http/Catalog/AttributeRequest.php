<?php
namespace AppBundle\Http\Catalog;

use AppBundle\Service\Scope;
use GuzzleHttp\Psr7\Request;

/**
 * Class AttributeRequest
 * @package AppBundle\Http\Catalog
 */
class AttributeRequest extends Request
{
    /**
     * @var array
     */
    private $uris = [
        Scope::URI_TYPE_GLOBAL => 'V1/products/attributes/:attributeId/options'
    ];

    /**
     * AttributeRequest constructor.
     * 
     * @param Scope $scopeContext
     * @param \Psr\Http\Message\UriInterface|string $attributeId
     * @param array $adminToken
     */
    public function __construct(Scope $scopeContext, $attributeId, $adminToken)
    {
        $headers = [
            "Content-Type" => "application/json",
        ];
        $uri = $scopeContext->prepareUri($this->uris);
        $uri = str_replace(':attributeId', $attributeId, $uri);
        $headers = $scopeContext->extendHeaders($headers, $adminToken);
        parent::__construct('GET', $uri, $headers);
    }
}