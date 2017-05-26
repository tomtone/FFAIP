<?php
namespace AppBundle\Service\Checkout;

use AppBundle\Http\RequestFactory;
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
     * @var RequestFactory
     */
    private $requestFactory;

    /**
     * Cart constructor.
     * @param RequestFactory $requestFactory
     */
    public function __construct(RequestFactory $requestFactory)
    {
        $this->requestFactory = $requestFactory;
    }

    public function getItems()
    {
        $request = $this->requestFactory->getCartItemRequest();
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
        $request = $this->requestFactory->getCartItemRequest();
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
        $request = $this->requestFactory->getCartRequest();
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

        $addToCartRequest = $this->requestFactory->getAddToCartRequest($productData);

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

    public function getTotals()
    {
        $request = $this->requestFactory->getPaymentInformationRequest();
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
}