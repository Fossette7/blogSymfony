<?php
/**
 * Created by PhpStorm.
 * User: bricepeyrat
 * Date: 26/04/2020
 * Time: 12:18
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * About controller.
 *
 * @Route("about")
 */
class AboutController extends Controller
{
    /**
     * Lists all Post entities.
     *
     * @Route("/", name="about_index")
     * @Method("GET")
     */
public function aboutDisplay()
{

    //je retourne une vue seulement pour visionner
    return $this->render('about/index.html.twig');

}
}