<?php
namespace AppBundle\Service\Catalog;

class Product extends \AppBundle\Service\AbstractAdminRequest
{
    public function getProduct($sku)
    {
        $cachedItem = $this->cacheAdapter->getItem('product_'. $sku);
        $response = $cachedItem->get();
        if($response == null) {
            $bearerToken = $this->getBearerToken();
            $request = $this->requestFactory->getProductDataRequest($bearerToken, $sku);
            $response = $this->request($request);
            $cachedItem->set($response);
            $cachedItem->expiresAfter(300);
            $this->cacheAdapter->save($cachedItem);
        }

        return $response;
    }

    private function prepareRequest($bearerToken, $sku)
    {
        $request = new \GuzzleHttp\Psr7\Request(
            'GET',
            $this->shopUrl . 'rest/V1/products/'. $sku,
            [
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . $bearerToken
            ]
        );

        return $request;
    }
}
