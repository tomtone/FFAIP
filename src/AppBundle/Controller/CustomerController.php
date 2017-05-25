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
        return $this->render('customer/index.html.twig', [
            'customer' => $this->get('security.token_storage')->getToken()->getUser(),
        ]);
    }
}
