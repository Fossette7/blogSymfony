<?php
/**
 * Created by PhpStorm.
 * User: bricepeyrat
 * Date: 29/03/2020
 * Time: 01:09
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use AppBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Home - User bloglist controller.
 *
 * @Route("/")
 */
class HomeController extends Controller
{
    /**
     * Lists all Post entities.
     *
     * @Route("/", name="home_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        //repository est pour selectionner une entity, on défini la variable
        $allPosts = $em->getRepository('AppBundle:Post')->findAll();

        //je retourne une vue seulement pour visionner les posts
        return $this->render('home/index.html.twig', array(
            //nom de la variable twig qui représente notre tableau => nom de la variable qui contient le repository de l'objet
            //donc nos éléments du tableau
            'allPosts' => $allPosts,
        ));
    }

        /**
         * Finds and displays a Post entity & comments entity.
         *
         * @Route("/post/{id}", name="home_post_show")
         * @Method("GET")
         */
        //Affichage d'un article et ses commentaires
        //la fonction show utilise l'objet "Post"
        //Request permet de recevoir les données du formulaire
        public function showAction(Post $post, Request $request)
    {
        //On instancie l'entité Comment
        $comment = new Comment();

        //création de l'objet formulaire
        $form = $this->createForm(CommentType::class, $comment);

        //On récupère les données saisies du form
        $form->handleRequest($request);

        //On vérifie si form a été envoyé et est valide
        if($form->isSubmitted()&& $form->isValid()){
            //on entre dans la condition
            $comment->setPost($post);
            $comment->setCreatedAt( new \DateTime('now'));

            //On hydrate notre objet pour alimenter la BDD, instance de doctrine
            $doctrine = $this->getDoctrine()->getManager();

            //On garde en stock cette hydratation $comment
            $doctrine->persist($comment);

            //On enregistre dans la BDD
            $doctrine->flush();

        }

        return $this->render('home/show.html.twig', array(
            'post' => $post,
            'formComment' => $form->createView(),
        ));
    }


    }