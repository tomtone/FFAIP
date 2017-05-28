<?php
namespace AppBundle\Service\Sales;


use AppBundle\Http\RequestFactory;
use AppBundle\Service\AbstractAdminRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Order extends AbstractAdminRequest
{
    public function getOrders()
    {
        $request = $this->requestFactory->getSalesOrderRequest($this->getBearerToken());
        $client = new Client();
        try {
            $response = $client->send($request);
        } catch (RequestException $e) {
            dump($e->getResponse()->getBody()->getContents());
            return 0;
        }
        $responseData = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        return $responseData;
    }
}