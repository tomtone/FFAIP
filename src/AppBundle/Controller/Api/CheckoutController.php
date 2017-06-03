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
     */
    public function shippingMethodsAction(Request $request)
    {
        $data = $this->generatorInterface->generate("checkout_shipping_methods");
        return new JsonResponse([
            'customer' => $data,
        ]);
    }


    /**
     * @Route("/api/checkout/totals_information",
     *   name="api_checkout_totals_information"
     * )
     */
    public function changeAddressAction(Request $request)
    {
        $payload = [
            "addressInformation" => [
                "address" => [
                    "id" => 1
                ]
            ]
        ];
        $data = $this->generatorInterface->generate("checkout_totals_information", $payload);
        return new JsonResponse([
            'customer' => $data,
        ]);
    }
}
