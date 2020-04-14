<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Blog_post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Blog_post controller.
 *
 * @Route("post")
 */
class Blog_postController extends Controller
{
    /**
     * Lists all blog_post entities.
     *
     * @Route("/", name="post_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $blog_posts = $em->getRepository('AppBundle:Blog_post')->findAll();

        return $this->render('blog_post/index.html.twig', array(
            'blog_posts' => $blog_posts,
        ));
    }

    /**
     * Creates a new blog_post entity.
     *
     * @Route("/new", name="post_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $blog_post = new Blog_post();
        $blog_post->setCreatedAt(new\DateTime('now'));
        $form = $this->createForm('AppBundle\Form\Blog_postType', $blog_post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog_post);
            $em->flush();

            return $this->redirectToRoute('post_show', array('id' => $blog_post->getId()));
        }

        return $this->render('blog_post/new.html.twig', array(
            'blog_post' => $blog_post,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a blog_post entity.
     *
     * @Route("/{id}", name="post_show")
     * @Method("GET")
     */
    public function showAction(Request $request, Blog_post $blog_post)
    {
        return $this->render('blog_post/show.html.twig', array(
            'blog_post' => $blog_post
        ));
    }

    /**
     * Displays a form to edit an existing blog_post entity.
     *
     * @Route("/edit/{id}", name="post_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Blog_post $blog_post)
    {
        $deleteForm = $this->createDeleteForm($blog_post);
        $editForm = $this->createForm('AppBundle\Form\Blog_postType', $blog_post);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_edit', array('id' => $blog_post->getId()));
        }
        return $this->render('blog_post/edit.html.twig', array(
            'blog_post' => $blog_post,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a blog_post entity.
     *
     * @Route("/{id}", name="post_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Blog_post $blog_post)
    {
        $form = $this->createDeleteForm($blog_post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($blog_post);
            $em->flush();
        }

        return $this->redirectToRoute('post_index');
    }

    /**
     * Creates a form to delete a blog_post entity.
     *
     * @param Blog_post $blog_post The blog_post entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Blog_post $blog_post)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('post_delete', array('id' => $blog_post->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
