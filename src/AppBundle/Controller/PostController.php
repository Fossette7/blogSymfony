<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Post controller.
 *
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN", message="Accès utilisateur, veuillez-vous connecter!")
 *
 */
class PostController extends Controller
{
    /**
     * Lists all Post entities.
     *
     * @Route("/", name="post_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $BlogPosts = $em->getRepository('AppBundle:Post')->findAll();

        return $this->render('post/index.html.twig', array(
            'BlogPosts' => $BlogPosts,
        ));
    }

    /**
     * Creates a new Post entity.
     *
     * @Route("/new", name="post_new")
     * @Method({"GET", "POST"})
     */
    public function createPost(Request $request)
    {
        $BlogPost = new Post();
        $BlogPost->setCreatedAt(new\DateTime('now'));
        $form = $this->createForm('AppBundle\Form\PostType', $BlogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($BlogPost);
            $em->flush();

            return $this->redirectToRoute('post_show', array('id' => $BlogPost->getId()));
        }

        return $this->render('post/new.html.twig', array(
            'post' => $BlogPost,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Post entity.
     *
     * @Route("/post/{id}", name="post_show")
     * @Method("GET")
     */
    public function showPost(Request $request, Post $BlogPost = null)
    {
        if($BlogPost === null){
            //throw new \Exception('Une erreur s\'est produite!', 404);
            throw $this->createNotFoundException('Page inexistante - erreur 404');
        }

        return $this->render('post/show.html.twig', array(
            'post' => $BlogPost
        ));
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     * @Route("/edit/{id}", name="post_edit")
     * @Method({"GET", "POST"})
     */
    public function editPost(Request $request, Post $BlogPost)
    {

        $deleteForm = $this->createDeleteForm($BlogPost);
        $editForm = $this->createForm('AppBundle\Form\PostType', $BlogPost);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($BlogPost);
                $em->flush();

                $this->addFlash('success', 'Votre article est modifié');

                return $this->redirectToRoute('post_show', array(
                    'id' => $BlogPost->getId()
                ));

        }
        return $this->render('post/edit.html.twig', array(
            'post' => $BlogPost,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Post entity.
     *
     * @Route("/delete/{id}", name="post_delete")
     * @Method("DELETE")
     */
    public function deletePost(Request $request, Post $blogPost)
    {
        $form = $this->createDeleteForm($blogPost);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($blogPost);
            $em->flush();

        }
        //redirect to list of post
        return $this->redirectToRoute('post_index');
    }

    /**
     * Creates a form to delete a Post entity.
     *
     * @param Post $blogPost The Post entity
     *
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Post $blogPost)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('post_delete', array('id' => $blogPost->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
