<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * BlogPost controller.
 *
 * @Route("post")
 */
class BlogPostController extends Controller
{
    /**
     * Lists all BlogPost entities.
     *
     * @Route("/", name="post_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $BlogPosts = $em->getRepository('AppBundle:BlogPost')->findAll();

        return $this->render('BlogPost/index.html.twig', array(
            'BlogPosts' => $BlogPosts,
        ));
    }

    /**
     * Creates a new BlogPost entity.
     *
     * @Route("/new", name="post_new")
     * @Method({"GET", "POST"})
     */
    public function createPost(Request $request)
    {
        $BlogPost = new BlogPost();
        $BlogPost->setCreatedAt(new\DateTime('now'));
        $form = $this->createForm('AppBundle\Form\BlogPostType', $BlogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($BlogPost);
            $em->flush();

            return $this->redirectToRoute('post_show', array('id' => $BlogPost->getId()));
        }

        return $this->render('BlogPost/new.html.twig', array(
            'BlogPost' => $BlogPost,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a BlogPost entity.
     *
     * @Route("/{id}", name="post_show")
     * @Method("GET")
     */
    public function showPost(Request $request, BlogPost $BlogPost)
    {
        return $this->render('BlogPost/show.html.twig', array(
            'BlogPost' => $BlogPost
        ));
    }

    /**
     * Displays a form to edit an existing BlogPost entity.
     *
     * @Route("/edit/{id}", name="post_edit")
     * @Method({"GET", "POST"})
     */
    public function editPost(Request $request, BlogPost $BlogPost)
    {
        $deleteForm = $this->createDeleteForm($BlogPost);
        $editForm = $this->createForm('AppBundle\Form\BlogPostType', $BlogPost);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_edit', array('id' => $BlogPost->getId()));
        }
        return $this->render('BlogPost/edit.html.twig', array(
            'blog_post' => $BlogPost,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a BlogPost entity.
     *
     * @Route("/{id}", name="post_delete")
     * @Method("DELETE")
     */
    public function deletePost(Request $request, BlogPost $BlogPost)
    {
        $form = $this->createDeleteForm($BlogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($BlogPost);
            $em->flush();
        }

        return $this->redirectToRoute('post_index');
    }

    /**
     * Creates a form to delete a BlogPost entity.
     *
     * @param BlogPost $BlogPost The BlogPost entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BlogPost $BlogPost)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('post_delete', array('id' => $BlogPost->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
