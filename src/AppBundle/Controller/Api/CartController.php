<?php
namespace AppBundle\Controller\Api;

use AppBundle\Traits\Referer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CartController extends Controller
{
    /**
     * @Route("/api/cart",
     *   name="api_checkout_cart"
     * )
     */
    public function indexAction(Request $request)
    {
        $items = $this->get('api.checkout.cart')->getCartItems();
        $totals = $this->get('api.checkout.cart')->getTotals();

        return new JsonResponse([
            'items' => $items,
            'totals' => $totals
        ]);
    }

    /**
     * @Route("/api/cart/items/{itemId}",
     *   name="api_cart_items_delete"
     * )
     * @Method("DELETE")
     */
    public function removeItemAction(Request $request, $itemId)
    {
        $items = $this->get('api.checkout.cart')->removeItemFromCart($itemId);

        return new JsonResponse([
            'ok' => "hello" ]);
    }
}
