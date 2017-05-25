<?php
namespace AppBundle\Service;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Cache\CacheItemPoolInterface;

abstract class AbstractAdminRequest
{
    /**
     * @var string
     */
    protected $shopUrl;

    /**
     * @var string
     */
    private $adminUser;

    /**
     * @var string
     */
    private $adminPassword;

    /**
     * @var CacheItemPoolInterface
     */
    protected $cacheAdapter;

    /**
     * AbstractAdminRequest constructor.
     * @param string $shopUrl
     * @param string $adminUser
     * @param string $adminPassword
     * @param CacheItemPoolInterface $cacheAdapter
     */
    public function __construct(string $shopUrl, string $adminUser, string $adminPassword, CacheItemPoolInterface $cacheAdapter)
    {
        $this->shopUrl = $shopUrl;
        $this->adminUser = $adminUser;
        $this->adminPassword = $adminPassword;
        $this->cacheAdapter = $cacheAdapter;
    }

    public function getBearerToken()
    {
        $userData = \json_encode(
            [
                'username' => $this->adminUser,
                'password' => $this->adminPassword
            ]
        );

        $request = new \GuzzleHttp\Psr7\Request(
            'POST',
            $this->shopUrl . 'rest/V1/integration/admin/token',
            [
                "Content-Type" => "application/json",
                "Content-Lenght" => strlen(json_encode($userData))
            ],
            $userData
        );

        $response = $this->request($request);
        return $response;
    }

    protected function request($request)
    {
        $client = new Client();
        try {
            $response = $client->send($request);
        }catch (RequestException $e){
            $responseData = \GuzzleHttp\json_decode($e->getResponse()->getBody()->getContents());
            if(property_exists($responseData, 'message')) {
                return $responseData->message;
            }else{
                return 'An Error occured';
            }
        }

        return \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
    }
}