<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 25.05.2017
 * Time: 19:36
 */

namespace AppBundle\Service\Checkout;


use AppBundle\Service\AbstractAdminRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
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
     * Cart constructor.
     * @param string $shopUrl
     * @param string $adminUser
     * @param string $adminPassword
     * @param CacheItemPoolInterface $cacheAdapter
     * @param TokenStorage $tokenStorage
     */
    public function __construct($shopUrl, string $adminUser, string $adminPassword, CacheItemPoolInterface $cacheAdapter, TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
        $this->shopUrl = $shopUrl;
        parent::__construct($shopUrl, $adminUser, $adminPassword, $cacheAdapter);
    }

    public function getShipping()
    {
        $request = new \GuzzleHttp\Psr7\Request(
            'GET',
            $this->shopUrl . 'rest/V1/customers/me/shippingAddress',
            [
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . $this->tokenStorage->getToken()->getAttribute('bearerToken')
            ]
        );
        $client = new Client();
        try {
            $response = $client->send($request);
        } catch (RequestException $e) {
            echo '<pre>';
            print_r($e->getResponse()->getBody()->getContents());
            die();
        }
        $responseData = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        if(empty($responseData)) {
            $request = new \GuzzleHttp\Psr7\Request(
                'GET',
                $this->shopUrl . 'rest/V1/attributeMetadata/customerAddress',
                [
                    "Content-Type" => "application/json",
                    "Authorization" => "Bearer " . $this->getBearerToken()
                ]
            );

            $responseData = $this->request($request);
        }
        var_dump($responseData);
        die();
        return $responseData;
    }
}