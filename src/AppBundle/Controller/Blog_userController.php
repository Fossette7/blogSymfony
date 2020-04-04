<?php
/**
 * Created by PhpStorm.
 * User: bricepeyrat
 * Date: 29/03/2020
 * Time: 01:09
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Blog_post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * User bloglist controller.
 *
 * @Route("listpost")
 */
class Blog_userController extends Controller
{
    /**
     * Lists all blog_post entities.
     *
     * @Route("/", name="blog_user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        //repository est pour selectionner une entity
        $blog_posts = $em->getRepository('AppBundle:Blog_post')->findAll();

        //je retourne une vue seulement pour visionner les posts
        return $this->render('blog_user/index.html.twig', array(
            'blog_posts' => $blog_posts,
        ));
    }

        /**
         * Finds and displays a blog_post entity.
         *
         * @Route("/blogpost/{id}", name="blogpost_show")
         * @Method("GET")
         */
        public function showAction(Request $request, Blog_post $blog_post)
    {

        //$deleteForm = $this->createDeleteForm($blog_post);

        return $this->render('blog_user/show.html.twig', array(
            'blog_post' => $blog_post,
            //'delete_form' => $deleteForm->createView(),
        ));
    }

    }