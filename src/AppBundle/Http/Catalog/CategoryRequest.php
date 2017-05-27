<?php
namespace AppBundle\Http\Catalog;

use AppBundle\Service\Scope;
use GuzzleHttp\Psr7\Request;

class CategoryRequest extends Request
{
    private $uris = [
        Scope::URI_TYPE_GLOBAL => 'V1/categories/:categoryId/products',
        Scope::URI_TYPE_CUSTOMER => 'V1/carts/mine'
    ];
    
    public function __construct(Scope $scopeContext, $categoryId, $adminToken)
    {
        $headers = [
            "Content-Type" => "application/json",
        ];
        $uri = $scopeContext->prepareUri($this->uris);
        $uri = str_replace(':categoryId',$categoryId, $uri);
        $headers = $scopeContext->extendHeaders($headers, $adminToken);
        parent::__construct('GET', $uri, $headers);
    }
}