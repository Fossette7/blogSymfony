<?php
/**
 * Created by PhpStorm.
 * User: bricepeyrat
 * Date: 09/03/2020
 * Time: 00:06
 */

namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdvertController extends Controller
{

    /**
     * @Route("/advert", name="advert-page")
     */
    public function index()
    {
        $content = "Notre propre Hello World";
        return $this->render('advert/display.html.twig', ['param1' => $content]);
    }

    /**
     * @Route("/adverto", name="advertfft-page")
     */
    public function indexbg()
    {
        $content = "Page 2";
        return $this->render('advert/display.html.twig', ['param1' => $content]);
    }
}