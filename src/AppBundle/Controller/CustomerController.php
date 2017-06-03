<?php

namespace AppBundle\Controller;

use GuzzleHttp\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CustomerController extends Controller
{
    /**
     * @Route("/customer", name="customer")
     */
    public function indexAction(Request $request)
    {
        $data = $this->get('app.strategy.generator')->generate("sales_order");

        return $this->render('customer/index.html.twig', [
            'customer' => $this->get('security.token_storage')->getToken()->getUser(),
            'orders' => $data
        ]);
    }

    /**
     * @Route("/customer/order/{orderId}",name="customer_order")
     */
    public function orderViewAction($orderId)
    {
        $data = $this->get('app.strategy.generator')->generate("sales_order", $orderId);

        return $this->render('customer/orders.html.twig', [
            'order' => $data
        ]);
    }
}
