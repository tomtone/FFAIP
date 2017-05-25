<?php
namespace AppBundle\Service\Checkout;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class Cart
 * @package AppBundle\Service\Checkout
 */
class Cart
{
    /**
     * @var TokenStorage
     */
    private $tokenStorage;
    private $shopUrl;

    /**
     * Cart constructor.
     * @param $shopUrl
     * @param TokenStorage $tokenStorage
     */
    public function __construct($shopUrl, TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
        $this->shopUrl = $shopUrl;
    }

    public function getItems()
    {
        $request = new \GuzzleHttp\Psr7\Request(
            'GET',
            $this->shopUrl . 'rest/V1/carts/mine/items',
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
        $qty = 0;
        foreach ($responseData as $item){
            $qty += $item['qty'];
        }

        return $qty;
    }

    public function getCartItems()
    {
        $request = new \GuzzleHttp\Psr7\Request(
            'GET',
            $this->shopUrl . 'rest/V1/carts/mine/items',
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

        return $responseData;
    }

    public function addToCart($sku, $qty, $attributes = [])
    {
        $request = new \GuzzleHttp\Psr7\Request(
            'GET',
            $this->shopUrl . 'rest/V1/carts/mine',
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
        $quoteId = $responseData['id'];

        $productData = $this->createAddToCartPayload($quoteId, $sku, $qty, $attributes);

        $addToCartRequest = new \GuzzleHttp\Psr7\Request(
            'POST',
            $this->shopUrl . 'rest/V1/carts/mine/items',
            [
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . $this->tokenStorage->getToken()->getAttribute('bearerToken')
            ],
            \GuzzleHttp\json_encode($productData)
        );

        try {
            $response = $client->send($addToCartRequest);
        } catch (RequestException $e) {
            echo '<pre>';
            print_r($e->getResponse()->getBody()->getContents());
            die();
        }

        $responseData = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
    }

    public function __call($name, $arguments)
    {
        $method = 'get'. ucfirst($name);
        if (method_exists($this, $method)){
            return $this->$method;
        }
    }

    private function createAddToCartPayload($quoteId, $sku, $qty, $attributes)
    {
        $payLoad = [
            'cart_item' => [
                'quote_id' => $quoteId,
                'sku' => $sku,
                'qty' => $qty
            ]
        ];

        if(count($attributes) > 0){
            $options = [];
            foreach ($attributes as $key => $attribute){
                $options[] = [
                    "optionId"=> $key,
                    "optionValue"=> $attribute
                ];
            }
            $payLoad['cart_item']['productOption'] = [
                'extensionAttributes' => [
                    'configurableItemOptions' => $options
                ]
            ];
        }

        return $payLoad;
    }
}