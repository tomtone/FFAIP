<?php
namespace AppBundle\Service;

class CustomerData
{
    protected $shopUrl;

    public function __construct($shopUrl)
    {
        $this->shopUrl = $shopUrl;
    }

    public function create($token)
    {
        #$userData = \json_encode(
        #    [
        #        'username' => 'info@von-gostomski.eu',
        #        'password' => 'paSSword11'
        #    ]
        #);

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
}