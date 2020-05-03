<?php
/**
 * Created by PhpStorm.
 * User: bricepeyrat
 * Date: 03/05/2020
 * Time: 19:07
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;




/**
 * @Route("contact")
 * @method ("GET")
 */

class ContactController extends Controller
{
    /**
     * @Route("/", name="contact")
     */
    public function contactAction()
    {
        //empty  public function contact(\Swift_Mailer $mailer, Request $request)
        return new Response('<html><body>Contact Form Page!</body></html>');
    }
}