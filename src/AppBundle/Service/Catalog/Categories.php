<?php
namespace AppBundle\Service\Catalog;

class Categories extends \AppBundle\Service\AbstractAdminRequest
{
    public function getCategories()
    {
        $cachedItem = $this->cacheAdapter->getItem('categories');
        $response = $cachedItem->get();
        if($response == null) {
            $bearerToken = $this->getBearerToken();
            $request = $this->requestFactory->getCategoriesRequest($bearerToken);
            $response = $this->request($request);
            $response = $response['children_data'];
            $cachedItem->set($response);
            $cachedItem->expiresAfter(300);
            $this->cacheAdapter->save($cachedItem);
        }
        return $response;
    }

    public function getCategory($categoryId)
    {
        $cachedItem = $this->cacheAdapter->getItem('category_'. $categoryId);
        $response = $cachedItem->get();
        if($response == null) {
            $bearerToken = $this->getBearerToken();
            $request = $this->requestFactory->getCategoryRequest($bearerToken, $categoryId);
            $response = $this->request($request);
            foreach ($response as $key => $product) {
                $product['product'] = $this->request($this->requestFactory->getProductDataRequest($bearerToken, $product['sku']));
                $response[$key] = $product;
            }
            $cachedItem->set($response);
            $cachedItem->expiresAfter(300);
            $this->cacheAdapter->save($cachedItem);
        }

        return $response;
    }

    private function prepareRequest($bearerToken)
    {
        $request = new \GuzzleHttp\Psr7\Request(
            'GET',
            $this->shopUrl . 'rest/V1/categories',
            [
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . $bearerToken
            ]
        );

        return $request;
    }

    private function prepareCategoryRequest($bearerToken, $categoryId)
    {
        $request = new \GuzzleHttp\Psr7\Request(
            'GET',
            $this->shopUrl . 'rest/V1/categories/'.$categoryId . '/products',
            [
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . $bearerToken
            ]
        );

        return $request;
    }

    private function getProductData($bearerToken, $sku)
    {
        $request = new \GuzzleHttp\Psr7\Request(
            'GET',
            $this->shopUrl . 'rest/V1/products/'. $sku,
            [
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . $bearerToken
            ]
        );

        $response = $this->request($request);

        return $response;
    }
}
