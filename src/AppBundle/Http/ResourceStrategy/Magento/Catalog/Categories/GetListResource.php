<?php
namespace AppBundle\Http\ResourceStrategy\Magento\Catalog\Categories;

use AppBundle\Http\ResourceStrategy\AbstractAdminResourceStrategy;
use AppBundle\Http\ResourceStrategy\ResourceStrategyInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class GetListResource
    extends AbstractAdminResourceStrategy
    implements
    ResourceStrategyInterface
{
    /**
     * @var string resource target uri
     */
    protected $uri = "V1/categories/:categoryId/products";

    /**
     * @var string Request Method
     */
    protected $method = "GET";

    /**
     * @var string resource
     */
    protected $resourceName = "catalog_category_view";

    /**
     * @param array|null $args
     *
     * @return array
     */
    public function request($args = null) : array
    {
        $categoryId = reset($args);
        $uri = str_replace(':categoryId', $categoryId, $this->uri);
        $uri = $this->scopeContext->prepareUri(['global' => $uri]);
        $request = new Request('GET', $uri, $this->header);
        $client = new Client();
        $response = $client->send($request);
        $response = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

        foreach ($response as $key => $product) {
            $product['product'] = $this->resourceGenerator->generate('catalog_product_view', $product['sku']);
            $response[$key] = $product;
        }

        return $response;
    }
}