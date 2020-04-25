<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Post controller.
 *
 * @Route("post")
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

        return $this->render('blog_post/index.html.twig', array(
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

        return $this->render('blog_post/new.html.twig', array(
            'Post' => $BlogPost,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Post entity.
     *
     * @Route("/{id}", name="post_show")
     * @Method("GET")
     */
    public function showPost(Request $request, Post $BlogPost)
    {
        return $this->render('blog_post/show.html.twig', array(
            'Post' => $BlogPost
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
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_edit', array('id' => $BlogPost->getId()));
        }
        return $this->render('blog_post/edit.html.twig', array(
            'blog_post' => $BlogPost,
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
            dump($blogPost);
            $em = $this->getDoctrine()->getManager();
            $em->remove($blogPost);
            $em->flush();
            die;
        }

        return $this->redirectToRoute('post_index');
    }

    /**
     * Creates a form to delete a Post entity.
     *
     * @param Post $blogPost The Post entity
     *
     * @return \Symfony\Component\Form\Form The form
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
