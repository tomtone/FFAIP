<?php

namespace AppBundle\Controller;

use GuzzleHttp\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $client = new Client();
        #$request = $this->get('api.customer.create')->create();
        #$request = $this->get('api.customer.login')->create();
        #$response = $client->send($request);
        #$token = \json_decode($response->getBody()->getContents());

        #$request = $this->get('api.customer.data')->create($token);
        #$response = $client->send($request);
        #var_dump(\json_decode($response->getBody()->getContents()));
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/other", name="other")
     */
    public function otherAction(Request $request)
    {
        $client = new Client();
        #$request = $this->get('api.customer.create')->create();
        #$request = $this->get('api.customer.login')->create();
        #$response = $client->send($request);
        #$token = \json_decode($response->getBody()->getContents());

        #$request = $this->get('api.customer.data')->create($token);
        #$response = $client->send($request);
        #var_dump(\json_decode($response->getBody()->getContents()));
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
        ]);
    }
}
