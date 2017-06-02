<?php
namespace AppBundle\Http\ResourceStrategy;


use AppBundle\Http\MagentoResourceGenerator;
use AppBundle\Service\Scope;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

abstract class AbstractAdminResourceStrategy extends AbstractResourceStrategy
{
    /**
     * @var string
     */
    private $adminPassword;

    /**
     * @var string
     */
    private $adminUser;

    /**
     * @var string bearer Token for admin requests
     */
    protected $bearerToken = "";

    /**
     * AbstractAdminResourceStrategy constructor.
     *
     * @param Scope $scopeContext
     * @param MagentoResourceGenerator $resourceGenerator
     * @param $adminUser
     * @param $adminPassword
     */
    public function __construct(Scope $scopeContext, MagentoResourceGenerator $resourceGenerator, $adminUser, $adminPassword)
    {
        parent::__construct($scopeContext,$resourceGenerator);
        $this->adminPassword = $adminPassword;
        $this->adminUser = $adminUser;

        $this->createBearer();
    }

    private function createBearer()
    {
        $client = new Client();

        $payload = \json_encode(
            [
                'username' => $this->adminUser,
                'password' => $this->adminPassword
            ]
        );

        $headers = [
            "Content-Type" => "application/json",
        ];
        /** @ToDo refactor prepareURI */
        $uri = $this->scopeContext->prepareUri(['global' =>"V1/integration/admin/token"]);
        $request = new Request('POST', $uri, $headers, $payload);

        $response = $client->send($request);

        $this->bearerToken = \GuzzleHttp\json_decode($response->getBody()->getContents());

        $this->header["Authorization"] = "Bearer " . $this->bearerToken;
    }


}