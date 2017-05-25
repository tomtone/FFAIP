<?php
namespace AppBundle\Service;

use AppBundle\Security\User\Customer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class CustomerData
{
    protected $shopUrl;

    public function __construct($shopUrl)
    {
        $this->shopUrl = $shopUrl;
    }

    public function create($token)
    {
        $request = new \GuzzleHttp\Psr7\Request(
            'GET',
            $this->shopUrl . 'rest/V1/customers/me',
            [
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . $token
            ]
        );

        return $request;
    }

    public function request($token)
    {
        $request = $this->create($token);
        $client = new Client();
        try {
            $response = $client->send($request);
        }catch (RequestException $e){
            echo '<pre>';
            print_r($e->getResponse()->getBody()->getContents());
            die();
//            $responseData = \GuzzleHttp\json_decode($e->getResponse()->getBody()->getContents());
            return false;
//            if(property_exists($responseData, 'message')) {
//                return $responseData->message;
//            }else{
//                return false;
//            }
        }

        $responseData = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

        return new Customer($responseData);
    }
}