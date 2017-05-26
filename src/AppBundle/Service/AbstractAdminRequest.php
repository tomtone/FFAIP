<?php
namespace AppBundle\Service;


use AppBundle\Http\RequestFactory;
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
     * @var RequestFactory
     */
    protected $requestFactory;

    /**
     * AbstractAdminRequest constructor.
     * @param RequestFactory $requestFactory
     */
    public function __construct(RequestFactory $requestFactory)
    {
        $this->requestFactory = $requestFactory;
        $this->cacheAdapter = $requestFactory->getCache();
    }

    public function getBearerToken()
    {
        $request = $this->requestFactory->getAdminTokenRequest();

        $response = $this->request($request);
        return $response;
    }

    protected function request($request)
    {
        $client = new Client();
        try {
            $response = $client->send($request);
        }catch (RequestException $e){
            dump($e);
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