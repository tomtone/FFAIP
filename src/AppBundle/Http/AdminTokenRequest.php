<?php
namespace AppBundle\Http;

use AppBundle\Service\Scope;
use GuzzleHttp\Psr7\Request;

/**
 * Class AdminTokenRequest
 * @package AppBundle\Http
 */
class AdminTokenRequest extends Request
{
    /**
     * @var array
     */
    private $uris = [
        Scope::URI_TYPE_GLOBAL => 'V1/integration/admin/token'
    ];

    /**
     * AdminTokenRequest constructor.
     * 
     * @param Scope $scopeContext
     * @param \Psr\Http\Message\UriInterface|string $adminUser
     * @param array $adminPassword
     */
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