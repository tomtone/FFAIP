<?php
namespace AppBundle\Controller\Api;

use AppBundle\Traits\Referer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Exception\RequestException;

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

    /**
     * @Route("/api/cart/items/{itemId}/update_qty",
     *   name="api_cart_items_update"
     * )
     * @Method("PUT")
     */
    public function updateQty(Request $request, $itemId)
    {
        $qty = $request->request->get('qty');
        $items = $this->get('api.checkout.cart')->updateItemQty($itemId, $qty);

        return new JsonResponse([
            'ok' => $qty
        ]);
    }

    /**
     * @Route("/api/cart/items",
     *   name="api_cart_items_add"
     * )
     * @Method("POST")
     */
    public function addItem(Request $request)
    {
        $qty = $request->request->get('_qty');
        $sku = $request->request->get('_sku');

        $attributes = $request->request->get('_attributes');

        try {
            $response = $this->get('api.checkout.cart')->addToCart($sku, $qty, $attributes);
            return new JsonResponse($response);

        } catch (RequestException $e) {
            $response = $e->getResponse()->getBody()->getContents();
            return new JsonResponse(json_decode($response), 500);
        }
    }
}
