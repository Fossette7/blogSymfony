<?php
/**
 * Created by PhpStorm.
 * User: bricepeyrat
 * Date: 29/03/2020
 * Time: 01:09
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Blog_comment;
use AppBundle\Entity\Blog_post;
use AppBundle\Form\Blog_commentType;
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
         * Finds and displays a blog_post entity & comments entity.
         *
         * @Route("/blogpost/{id}", name="blogpost_show")
         * @Method("GET")
         */
        //Affichage d'un article et ses commentaires
        //Request permet de recevoir les données du formulaire
        public function showAction(Blog_post $blog_post, Request $request)
    {
        //On instancie l'entité Blog_comment
        $comment = new Blog_comment();

        //création de l'objet formulaire
        $form = $this->createForm(Blog_commentType::class, $comment);

        //On récupère les données saisies du form
        $form->handleRequest($request);

        //On vérifie si form a été envoyé et est valide
        if($form->isSubmitted()&& $form->isValid()){
            //on entre dans la condition
            $comment->setBlogPost($blog_post);
            $comment->setCreatedAt( new \DateTime('now'));

            //On hydrate notre objet pour alimenter la BDD, instance de doctrine
            $doctrine = $this->getDoctrine()->getManager();

            //On hydrate $comment
            $doctrine->persist($comment);

            //On enregistre dans la BDD
            $doctrine->flush();
        }

        return $this->render('blog_user/show.html.twig', array(
            'blog_post' => $blog_post,
            'comments' => $blog_post->getBlogComments(),
            'formComment' => $form->createView()
        ));
    }


    }