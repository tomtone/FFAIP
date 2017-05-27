<?php
namespace AppBundle\Http\Catalog;

use AppBundle\Service\Scope;
use GuzzleHttp\Psr7\Request;

class CategoriesRequest extends Request
{
    private $uris = [
        Scope::URI_TYPE_GLOBAL => 'V1/categories'
    ];
    
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