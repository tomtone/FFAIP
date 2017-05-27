<?php
namespace AppBundle\Service\Catalog;


use AppBundle\Service\AbstractAdminRequest;

class ProductHelper extends AbstractAdminRequest
{
    public function getAttributeValue($index, $attribute)
    {
        $cachedItem = $this->cacheAdapter->getItem('attribute_'. $attribute['attribute_id']);
        $response = $cachedItem->get();
        if($response == null) {
            $bearerToken = $this->getBearerToken();
            $request = $this->requestFactory->getAttributeRequest($bearerToken, $attribute['attribute_id']);
            $response = $this->request($request);
            $cachedItem->set($response);
            $cachedItem->expiresAfter(300);
            $this->cacheAdapter->save($cachedItem);
        }
        $value = $this->searchForId($index, $response);
        return $value;
    }

    private function prepareRequest($bearerToken, $optionId)
    {
        $request = new \GuzzleHttp\Psr7\Request(
            'GET',
            $this->shopUrl . 'rest/V1/products/attributes/'. $optionId .'/options',
            [
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . $bearerToken
            ]
        );

        return $request;
    }

    private function searchForId($id, $array) {
        foreach ($array as $key => $val) {
            if ($val['value'] == $id) {
                return $val['label'];
            }
        }
        return null;
    }
}