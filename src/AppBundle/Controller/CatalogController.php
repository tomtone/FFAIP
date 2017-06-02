<?php
namespace AppBundle\Controller;


use AppBundle\Http\RequestGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class CatalogController
 * @package AppBundle\Controller
 * @Route(service="app.controller.catalog")
 */
class CatalogController
{
    private $generatorInterface;

    /**
     * CatalogController constructor.
     * @param RequestGeneratorInterface $generatorInterface
     */
    public function __construct(RequestGeneratorInterface $generatorInterface)
    {
        $this->generatorInterface = $generatorInterface;
    }
    /**
     * @Route("/catalog/categories", name="catalog_categories")
     * @Template("catalog/categories/index.html.twig")
     */
    public function indexAction()
    {
        $data = $this->generatorInterface->generate("catalog_category_list");

        return [
            'categories' => $data,
        ];
    }

    /**
     * @Route("/catalog/category/{id}", name="catalog_category")
     * @Template(":catalog/categories:category.html.twig")
     */
    public function categoryAction($id)
    {
        $data = $this->generatorInterface->generate("catalog_category_view", $id);

        return [
            'category' => $data,
        ];
    }
    /**
     * @Route("/catalog/product/{sku}", name="catalog_product")
     * @Template(":catalog/product:view.html.twig")
     */
    public function productAction($sku)
    {
        $data = $this->generatorInterface->generate('catalog_product_view', $sku);
        
        return [
            'product' => $data,
        ];
    }
}