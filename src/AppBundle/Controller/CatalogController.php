<?php
namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CatalogController extends Controller
{
    /**
     * @Route("/catalog/categories", name="catalog_categories")
     */
    public function indexAction(Request $request)
    {
        return $this->render('catalog/categories/index.html.twig', [
            'categories' => $this->get('api.catalog.categories')->getCategories(),
        ]);
    }

    /**
     * @Route("/catalog/category/{id}", name="catalog_category")
     */
    public function categoryAction(Request $request, $id)
    {
        return $this->render('catalog/categories/category.html.twig', [
            'category' => $this->get('api.catalog.categories')->getCategory($id),
        ]);
    }
    /**
     * @Route("/catalog/product/{sku}", name="catalog_product")
     */
    public function productAction(Request $request, $sku)
    {
        return $this->render('catalog/product/view.html.twig', [
            'product' => $this->get('api.catalog.product')->getProduct($sku),
        ]);
    }
}