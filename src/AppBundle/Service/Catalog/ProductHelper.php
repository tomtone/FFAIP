<?php
namespace AppBundle\Service\Catalog;


use AppBundle\Http\MagentoResourceGenerator;
use AppBundle\Service\AbstractAdminRequest;

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
    
    public function getAttributeValue($index, $attribute)
    {
        $data = $this->resourceGenerator->generate('catalog_product_attribute', $attribute['attribute_id']);
        $value = $this->searchForId($index, $data);
        return $value;
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