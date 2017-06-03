<?php

namespace AppBundle\Service\Catalog;


use AppBundle\Http\MagentoResourceGenerator;
use AppBundle\Service\AbstractAdminRequest;
use GuzzleHttp\Psr7\Request;

class ProductHelper
{
    /**
     * @var MagentoResourceGenerator
     */
    private $resourceGenerator;

    /**
     * ProductHelper constructor.
     * @param MagentoResourceGenerator $resourceGenerator
     */
    public function __construct(MagentoResourceGenerator $resourceGenerator)
    {
        $this->resourceGenerator = $resourceGenerator;
    }

    public function getAttributeValue($optionId, $attribute)
    {
        $data = $this->resourceGenerator->generate('catalog_product_attribute', $attribute['attribute_id']);
        $value = $this->searchForId($optionId, $data);
        return $value;
    }

    private function searchForId($optionId, $array)
    {
        foreach ($array as $key => $val) {
            if ($val['value'] == $optionId) {
                return $val['label'];
            }
        }
        return null;
    }

    public function getConfigurableAttributesJson(array $attributes)
    {
        $options = [];
        foreach ($attributes as $attribute){
            $option = [
                'label' => $attribute['label'],
                'attribute_id' => $attribute['attribute_id'],
                'id' => $attribute['id'],

            ];
            $values = [];
            foreach ($attribute['values'] as $value){
                $label = $this->getAttributeValue($value['value_index'], $attribute);
                $values[] = [
                    'value' => $value['value_index'],
                    'label' => $label
                ];
            }
            $option['options'] = $values;
            $options[] = $option;
        }
        return \GuzzleHttp\json_encode(
            $options
        );
    }

    public function getPrice($product)
    {
        $minPrice = $product['price'];
        $maxPrice = $product['price'];
        if ($product['type_id'] == "configurable") {
            $minPrice = $product['price'];
            $maxPrice = $product['price'];
            foreach ($product['child_products'] as $product) {
                if ($product['price'] > $maxPrice) {
                    $maxPrice = $product['price'];
                }
                if ($product['price'] < $minPrice) {
                    $minPrice = $product['price'];
                }
            }
        }

        return $maxPrice;
    }
}