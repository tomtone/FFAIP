<?php
namespace AppBundle\Http\Catalog;

use AppBundle\Service\Scope;
use GuzzleHttp\Psr7\Request;

class ProductRequest extends Request
{
    private $uris = [
        Scope::URI_TYPE_GLOBAL => 'V1/products/:sku'
    ];

    public function __construct(Scope $scopeContext, $sku, $adminToken)
    {
        $headers = [
            "Content-Type" => "application/json",
        ];
        $uri = $scopeContext->prepareUri($this->uris);
        $uri = str_replace(':sku',$sku, $uri);
        $headers = $scopeContext->extendHeaders($headers, $adminToken);
        parent::__construct('GET', $uri, $headers);
    }
}