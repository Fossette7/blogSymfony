<?php
/**
 * Created by PhpStorm.
 * User: bricepeyrat
 * Date: 29/03/2020
 * Time: 01:09
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Blog_comment;
use AppBundle\Entity\Post;
use AppBundle\Form\BlogCommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * User bloglist controller.
 *
 * @Route("listpost")
 */
class HomeController extends Controller
{
    /**
     * Lists all Post entities.
     *
     * @Route("/", name="blog_user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        //repository est pour selectionner une entity
        $BlogPosts = $em->getRepository('AppBundle:Post')->findAll();

        //je retourne une vue seulement pour visionner les posts
        return $this->render('blog_user/index.html.twig', array(
            'blog_posts' => $BlogPosts,
        ));
    }

        /**
         * Finds and displays a Post entity & comments entity.
         *
         * @Route("/blogpost/{id}", name="blogpost_show")
         * @Method("GET")
         */
        //Affichage d'un article et ses commentaires
        //Request permet de recevoir les données du formulaire
        public function showAction(Post $BlogPost, Request $request)
    {
        //On instancie l'entité Blog_comment
        $comment = new Comment();

        //création de l'objet formulaire
        $form = $this->createForm(BlogCommentType::class, $comment);

        //On récupère les données saisies du form
        $form->handleRequest($request);

        //On vérifie si form a été envoyé et est valide
        if($form->isSubmitted()&& $form->isValid()){
            //on entre dans la condition
            $comment->setBlogPost($BlogPost);
            $comment->setCreatedAt( new \DateTime('now'));

            //On hydrate notre objet pour alimenter la BDD, instance de doctrine
            $doctrine = $this->getDoctrine()->getManager();

            //On hydrate $comment
            $doctrine->persist($comment);

            //On enregistre dans la BDD
            $doctrine->flush();
        }

        return $this->render('blog_user/show.html.twig', array(
            'Post' => $BlogPost,
            'comments' => $BlogPost->getComments(),
            'formComment' => $form->createView()
        ));
    }


    }