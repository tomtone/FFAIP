<?php
namespace AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends Controller
{
    /**
     * @Route("/api/catalog/product/{sku}", name="api_catalog_product")
     */
    public function productAction(Request $request, $sku)
    {
        $product = $this->get('app.strategy.generator')->generate('catalog_product_view', $sku);
        return new JsonResponse([
            'product' => $product
        ]);

    }
}

