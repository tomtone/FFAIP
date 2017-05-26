<?php
namespace AppBundle\Controller\Api;

use AppBundle\Traits\Referer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CheckoutController extends Controller
{
    /**
     * @Route("/api/checkout/cart",
     *   name="api_checkout_cart"
     * )
     */
    public function cartAction(Request $request)
    {
        $items = $this->get('api.checkout.cart')->getCartItems();
        $totals = $this->get('api.checkout.cart')->getTotals();

        return new JsonResponse([
            'items' => $items,
            'totals' => $totals
        ]);
    }
}
