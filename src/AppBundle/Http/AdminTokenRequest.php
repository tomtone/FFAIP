<?php
namespace AppBundle\Http;

use AppBundle\Service\Scope;
use GuzzleHttp\Psr7\Request;

class AdminTokenRequest extends Request
{
    private $uris = [
        Scope::URI_TYPE_GLOBAL => 'V1/integration/admin/token'
    ];
    
    public function __construct(Scope $scopeContext, $adminUser, $adminPassword)
    {
        $payload = \json_encode(
            [
                'username' => $adminUser,
                'password' => $adminPassword
            ]
        );

        $headers = [
            "Content-Type" => "application/json",
        ];
        $uri = $scopeContext->prepareUri($this->uris);
        $headers = $scopeContext->extendHeaders($headers);
        parent::__construct('POST', $uri, $headers, $payload);
    }
}