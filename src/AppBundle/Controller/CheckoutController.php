<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 25.05.2017
 * Time: 15:40
 */

namespace AppBundle\Controller;


use AppBundle\Form\ShippingFormType;
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

        $attributes = $request->request->get('_attributes');

        $this->get('api.checkout.cart')->addToCart($sku, $qty, $attributes);


        return $this->redirect($this->generateUrl('catalog_product', ['sku' => $sku]));
    }

    /**
     * @Route("/checkout/cart", name="checkout_cart")
     */
    public function cartAction()
    {
        $items = $this->get('api.checkout.cart')->getCartItems();
        $totals = $this->get('api.checkout.cart')->getTotals();
        
        return $this->render('checkout/cart.html.twig', [
            'items' => $items,
            'totals' => $totals
        ]);
    }

    /**
     * @Route("/checkout/shipping", name="checkout_shipping")
     */
    public function checkoutShippingAction()
    {
        $shipping = $this->get('api.checkout.shipping')->getShipping();
        $form = $this->get('form.factory')->create(ShippingFormType::class, null, [
            'requestFactory' => $this->get('app.factory.request')
        ]);
        return $this->render('checkout/shipping.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/checkout/payment", name="checkout_payment")
     */
    public function checkoutPaymentAction()
    {

    }
}