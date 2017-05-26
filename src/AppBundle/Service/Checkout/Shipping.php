<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 25.05.2017
 * Time: 19:36
 */

namespace AppBundle\Service\Checkout;


use AppBundle\Http\RequestFactory;
use AppBundle\Service\AbstractAdminRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class Shipping extends AbstractAdminRequest
{
    /**
     * @var TokenStorage
     */
    private $tokenStorage;
    protected $shopUrl;
    /**
     * @var RequestFactory
     */
    protected $requestFactory;

    /**
     * Cart constructor.
     * @param RequestFactory $requestFactory
     * @internal param string $shopUrl
     * @internal param string $adminUser
     * @internal param string $adminPassword
     * @internal param CacheItemPoolInterface $cacheAdapter
     * @internal param TokenStorage $tokenStorage
     */
    public function __construct(RequestFactory $requestFactory)
    {
        $this->requestFactory = $requestFactory;
        parent::__construct($requestFactory);
    }

    public function getShipping()
    {
        $request = $this->requestFactory->getShippingAddressRequest();
        
        $client = new Client();

        try {
            if($request !== false) {
                $response = $client->send($request);
            }else{
                $response = new Response(200,[],'{}');
            }
        } catch (RequestException $e) {
            echo '<pre>';
            print_r($e->getResponse()->getBody()->getContents());
            die();
        }
        $responseData = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        #if(empty($responseData)) {
        #    $request = $this->requestFactory->getAddressMetadataRequest($this->getBearerToken());
#
 #           $responseData = $this->request($request);
  #      }
   #     var_dump($responseData);
    #    die();
        return $responseData;
    }
}