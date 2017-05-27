<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 25.05.2017
 * Time: 15:40
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Address;
use AppBundle\Form\AddressFormType;
use AppBundle\Form\PaymentFormType;
use AppBundle\Form\ShippingMethodFormType;
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
     * @Method("GET")
     */
    public function checkoutShippingAction()
    {
        $shipping = $this->get('api.checkout.shipping')->getShipping();
        dump($shipping);
        $form = $this->get('form.factory')->create(AddressFormType::class, null, [
            'requestFactory' => $this->get('app.factory.request'),
            'type' => Address::ADDRESS_TYPE_SHIPPING
        ]);
        return $this->render('checkout/shipping.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/checkout/shipping", name="checkout_shipping_post")
     * @Method("POST")
     */
    public function checkoutShippingPostAction(Request $request)
    {
        $form = $this->get('form.factory')->create(AddressFormType::class, null, [
            'requestFactory' => $this->get('app.factory.request'),
            'type' => Address::ADDRESS_TYPE_SHIPPING
        ]);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()){
            $this->get('api.checkout.address')->saveAddress($form->getNormData());
            return $this->redirectToRoute('checkout_shipping_method');
        }
        return $this->render('checkout/shipping.html.twig',[
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/checkout/shipping_method", name="checkout_shipping_method")
     * @Method("GET")
     */
    public function checkoutShippingMethodAction(Request $request)
    {
        $form = $this->get('form.factory')->create(ShippingMethodFormType::class, null, [
            'requestFactory' => $this->get('app.factory.request')
        ]);
        return $this->render('checkout/shipping_method.html.twig',[
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/checkout/shipping_method", name="checkout_shipping_method_post")
     * @Method("POST")
     */
    public function checkoutShippingMethodPostAction(Request $request)
    {
        $form = $this->get('form.factory')->create(ShippingMethodFormType::class, null, [
            'requestFactory' => $this->get('app.factory.request')
        ]);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()){
            $this->get('api.checkout.address')->addShippingMethod($form->getNormData());
            return $this->redirectToRoute('checkout_billing');
        }
        return $this->render('checkout/shipping_method.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/checkout/billing", name="checkout_billing")
     * @Method("GET")
     */
    public function checkoutBillingAction(Request $request)
    {
        $addressData = $this->get('session')->get('cart_request');
        $form = $this->get('form.factory')->create(AddressFormType::class, $addressData['addressInformation']['shipping_address'], [
            'requestFactory' => $this->get('app.factory.request'),
            'type' => Address::ADDRESS_TYPE_BILLING
        ]);
        return $this->render('checkout/billing.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/checkout/billing", name="checkout_billing_post")
     * @Method("POST")
     */
    public function checkoutBillingPostAction(Request $request)
    {
        $form = $this->get('form.factory')->create(AddressFormType::class, null, [
            'requestFactory' => $this->get('app.factory.request'),
            'type' => Address::ADDRESS_TYPE_BILLING
        ]);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()){
            $this->get('api.checkout.address')->addBillingAddressMethod($form->getNormData());
            return $this->redirectToRoute('checkout_payment');
        }
        return $this->render('checkout/billing.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/checkout/review", name="checkout_review")
     * @Method("GET")
     */
    public function checkoutReviewAction(Request $request)
    {
        return $this->render('checkout/review.html.twig',[
            'order' => $this->get('session')->get('cart_request'),
            'items' => $items = $this->get('api.checkout.cart')->getCartItems()
        ]);
    }

    /**
     * @Route("/checkout/review", name="checkout_place_order")
     * @Method("POST")
     */
    public function checkoutPlaceOrderAction(Request $request)
    {
        $this->get('api.checkout.address')->placeOrder();
    }

    /**
     * @Route("/checkout/payment", name="checkout_payment")
     * @Method("GET")
     */
    public function checkoutPaymentAction()
    {
        $form = $this->get('form.factory')->create(PaymentFormType::class, null, [
            'requestFactory' => $this->get('app.factory.request')
        ]);
        return $this->render('checkout/payment.html.twig', [
           'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/checkout/payment", name="checkout_payment_post")
     * @Method("POST")
     */
    public function checkoutPaymentPostAction(Request $request)
    {
        $form = $this->get('form.factory')->create(PaymentFormType::class, null, [
            'requestFactory' => $this->get('app.factory.request')
        ]);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()){
            $this->get('api.checkout.address')->addPayment($form->getNormData());
            return $this->redirectToRoute('checkout_review');
        }
        return $this->render('checkout/payment.html.twig', [
            'form' => $form->createView()
        ]);
    }
}