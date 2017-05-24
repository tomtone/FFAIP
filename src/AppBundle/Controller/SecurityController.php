<?php
namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security_login_form")
     */
    public function loginAction()
    {
        return $this->render('default/index.html.twig');
    }
    
    /**
     * @Route("/login_check", name="security_login_check")
     */
    public function loginCheckAction()
    {
        throw $this->createNotFoundException('This should never be reached!');
    }
    /**
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
        throw $this->createNotFoundException('This should never be reached!');
    }
}