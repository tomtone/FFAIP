<?php
namespace AppBundle\Controller;


use AppBundle\Form\UserRegisterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="registration_form")
     */
    public function formAction(Request $request)
    {
        $form = $this->createForm(UserRegisterType::class)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $response = $this->get('api.customer.create')->create(
                $data['email'],
                $data['plainPassword'],
                $data['firstname'],
                $data['lastname']
            );
            return $this->redirectToRoute('registration_confirmed');
        }
        return $this->render('registration/register.html.twig', ['form' => $form->createView()]);
    }
    /**
     * @Route("/register/confirmed", name="registration_confirmed")
     */
    public function confirmedAction()
    {
        return $this->render('default/index.html.twig');
    }
}