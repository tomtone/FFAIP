<?php
namespace AppBundle\Service;


use AppBundle\Http\RequestFactory;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Psr\Cache\CacheItemPoolInterface;

abstract class AbstractAdminRequest
{
    /**
     * @var string
     */
    protected $shopUrl;
    protected $session;

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
        $this->session = $requestFactory->getSession();
    }

    public function getBearerToken()
    {
        $request = $this->requestFactory->getAdminTokenRequest();

        $response = $this->request($request);
        return $response;
    }

    /**
     * @param Request $request
     * @return mixed|string
     */
    protected function request($request)
    {
        $client = new Client();
        try {
            $response = $client->send($request);
        }catch (RequestException $e){
            $responseData = \GuzzleHttp\json_decode($e->getResponse()->getBody()->getContents());
            dump($responseData);
            if(property_exists($responseData, 'message')) {
                return $responseData->message;
            }else{
                return 'An Error occured';
            }
        }
        $contents = $response->getBody()->getContents();
        return \GuzzleHttp\json_decode($contents, true);
    }
}