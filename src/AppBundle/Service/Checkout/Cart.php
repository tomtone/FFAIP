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

    public function addToCart($sku, $qty)
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

        $addToCartRequest = new \GuzzleHttp\Psr7\Request(
            'POST',
            $this->shopUrl . 'rest/V1/carts/mine/items',
            [
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . $this->tokenStorage->getToken()->getAttribute('bearerToken')
            ],
            \GuzzleHttp\json_encode([
                'cart_item' => [
                    'quote_id' => $quoteId,
                    'sku' => $sku,
                    'qty' => $qty
                ]
            ])
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
}