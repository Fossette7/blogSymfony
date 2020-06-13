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
use Doctrine\ORM\Tools\Pagination\Paginator;
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
    public function indexAction(Request $request)
    {
        $maxArticleToGet = 3;
        $em = $this->getDoctrine()->getManager();
        $maxArticleOnBdd = $em->getRepository('AppBundle:Post')->getMaxPublishedArticleCount();
        $maxPage = ceil($maxArticleOnBdd/$maxArticleToGet);

        /** if(empty($page))
        {
            $page = 1;
        } else {
            $page = $request->query->get('page');
        }
         **/

        $page = (int)$request->query->get('page') ?? 1;

        // page controlle
        if(!is_int($page) || $page > $maxPage || $page < 1){
            $page = 1;
        }
        $articleToStart = ($page*$maxArticleToGet)-$maxArticleToGet;

        $allArticles = $em->getRepository('AppBundle:Post')->findBy(
            ['published' => 1],
            ['createdAt' => 'DESC'],
            $maxArticleToGet,$articleToStart
        );

        //repository est pour selectionner une entity, on défini la variable
        // $allPosts = $em->getRepository('AppBundle:Post')->findAll();
        /** @var Paginator $allArticles */
        //$allArticles = $em->getRepository('AppBundle:Post')->getArticles(10, $page);

        //je retourne une vue seulement pour visionner les posts
        return $this->render('home/index.html.twig', array(
            //nom de la variable twig qui représente notre tableau => nom de la variable qui contient le repository de l'objet
            //donc nos éléments du tableau
            //'allPosts' => $allPosts,
            'allArticles' => $allArticles,
            'page' => $page,
            'numberOfPage' => $maxPage

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
        public function showAction(Post $post = null, Request $request)
    {

        //On instancie l'entité Comment
        $comment = new Comment();

        //si le parametre id n'est pas trouvé
        if($post === null){
            throw $this->createNotFoundException('Page inexistante - erreur 404');
        }

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