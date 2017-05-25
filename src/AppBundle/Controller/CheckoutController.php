<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 25.05.2017
 * Time: 15:40
 */

namespace AppBundle\Controller;


use AppBundle\Traits\Referer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CheckoutController extends Controller
{
    /**
     * @Route("/checkout/add", name="checkout_add")
     * @Method("POST")
     */
    public function addAction(Request $request)
    {
        $qty = $request->request->get('_qty');
        $sku = $request->request->get('_sku');
        
        $this->get('api.checkout.cart')->addToCart($sku, $qty);


        return $this->redirect($this->generateUrl('catalog_product', ['sku' => $sku]));
    }

    /**
     * @Route("/checkout/cart", name="checkout_cart")
     */
    public function cartAction()
    {
        $items = $this->get('api.checkout.cart')->getCartItems();
        
        return $this->render('checkout/cart.html.twig', ['items' => $items]);
    }
}