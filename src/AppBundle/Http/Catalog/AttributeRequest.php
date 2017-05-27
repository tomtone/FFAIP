<?php
namespace AppBundle\Http\Catalog;

use AppBundle\Service\Scope;
use GuzzleHttp\Psr7\Request;

class AttributeRequest extends Request
{
    private $uris = [
        Scope::URI_TYPE_GLOBAL => 'V1/products/attributes/:attributeId/options'
    ];

    public function __construct(Scope $scopeContext, $attributeId, $adminToken)
    {
        $headers = [
            "Content-Type" => "application/json",
        ];
        $uri = $scopeContext->prepareUri($this->uris);
        $uri = str_replace(':attributeId',$attributeId, $uri);
        $headers = $scopeContext->extendHeaders($headers, $adminToken);
        parent::__construct('GET', $uri, $headers);
    }
}