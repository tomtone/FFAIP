<?php
namespace AppBundle\Controller\Api;

use AppBundle\Http\RequestGeneratorInterface;
use AppBundle\Traits\Referer;
use GuzzleHttp\Exception\RequestException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class: CustomerController
 *
 * @Route(service="app.controller.api.checkout")
 */
class CheckoutController extends Controller
{
    private $generatorInterface;

    /**
     * CatalogController constructor.
     * @param RequestGeneratorInterface $generatorInterface
     */
    public function __construct(RequestGeneratorInterface $generatorInterface)
    {
        $this->generatorInterface = $generatorInterface;
    }

    /**
     * @Route("/api/checkout/shipping_methods",
     *   name="api_checkout_shipping_methods"
     * )
     * @Method("POST")
     */
    public function shippingMethodsAction(Request $request)
    {
        $payload = $request->get('address');
        $payload['addressId'] = $payload['id'];
        $data = $this->generatorInterface->generate("checkout_shipping_methods", $payload);
        return new JsonResponse([
            'methods' => $data,
        ]);
    }

    /**
     * @Route("/api/checkout/payment_methods",
     *   name="api_checkout_payment_methods"
     * )
     */
    public function paymentMethodsAction(Request $request)
    {
        $data = $this->generatorInterface->generate("checkout_payment_methods");
        return new JsonResponse($data);
    }

    /**
     * @Route("/api/checkout/place_order",
     *   name="api_checkout_place_order"
     * )
     * @Method("POST")
     */
    public function placeOrder(Request $request)
    {
        $payload = $request->get('order');
        $data = $this->generatorInterface->generate("cart_order_put", $payload);
        return new JsonResponse($data);
    }
}
