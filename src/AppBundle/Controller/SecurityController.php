<?php
/**
 * Created by PhpStorm.
 * User: bricepeyrat
 * Date: 02/05/2020
 * Time: 11:48
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;



/**
 * @Route ("/")
 * @Method("GET")
 */

class SecurityController extends Controller
{
    /**
     * registration
     *
     * @Route("/log", name="registration")
     *
     */

    public function registrationAction()
    {
        return new Response('<html><body>Admin Page!</body></html>');
    }


    /**
     * @Route("/login", name="login")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        //get the login error if exist
        $error = $authenticationUtils->getLastAuthenticationError();

        //last username entered by the user
        $lastUsername=$authenticationUtils->getLastUsername();

        return $this->render('registration/registration.html.twig', [
            'last_username' =>  $lastUsername,
            'error'         =>  $error,
        ]);

    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {
        //this function will never be executed-> just URL needed for disconnect
        throw new \Exception('This should never be reached!');
    }



}