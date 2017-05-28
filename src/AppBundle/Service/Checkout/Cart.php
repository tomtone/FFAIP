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
            dump($e->getResponse()->getBody()->getContents());
            return 0;
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

    /**
     * addToCart
     *
     * @param mixed $sku
     * @param mixed $qty
     * @param mixed $attributes
     *
     * @throws RequestException
     */
    public function addToCart($sku, $qty, $attributes = [])
    {
        $request = $this->requestFactory->getCartRequest();
        $client = new Client();
        $response = $client->send($request);

        $responseData = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        $quoteId = $responseData['id'];
        $productData = $this->createAddToCartPayload($quoteId, $sku, $qty, $attributes);

        $addToCartRequest = $this->requestFactory->getAddToCartRequest($productData);

        $response = $client->send($addToCartRequest);
        return $response->getBody()->getContents();
    }

    public function removeItemFromCart($itemId)
    {
        $request = $this->requestFactory->removeItemFromCartRequest($itemId);
        $client = new Client();
        try {
            $response = $client->send($request);
        } catch (RequestException $e) {
            echo '<pre>';
            print_r($e->getResponse()->getBody()->getContents());
            die();
        }
    }

    public function updateItemQty($itemId, $qty)
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

        $request = $this->requestFactory->updateItemQtyRequest($quoteId, $itemId, $qty);
        $client = new Client();
        try {
            $response = $client->send($request);
        } catch (RequestException $e) {
            echo '<pre>';
            print_r($e->getResponse()->getBody()->getContents());
            die();
        }
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
