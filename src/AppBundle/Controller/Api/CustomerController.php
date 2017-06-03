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
 * @Route(service="app.controller.api.customer")
 */
class CustomerController extends Controller
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
     * @Route("/api/customer",
     *   name="api_customer"
     * )
     */
    public function indexAction(Request $request)
    {
        $data = $this->generatorInterface->generate("customer_customer");
        return new JsonResponse([
            'customer' => $data,
        ]);
    }
}
