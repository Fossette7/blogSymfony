<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Blog_comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Blog_comment controller.
 *
 * @Route("comment")
 */
class Blog_commentController extends Controller
{
    /**
     * Lists all blog_comment entities.
     *
     * @Route("/", name="comment_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $blog_comments = $em->getRepository('AppBundle:Blog_comment')->findAll();

        return $this->render('blog_comment/index.html.twig', array(
            'blog_comments' => $blog_comments,
        ));
    }

    /**
     * Creates a new blog_comment entity.
     *
     * @Route("/new", name="comment_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $blog_comment = new Blog_comment();
        $blog_comment->setCreatedAt(new\DateTime('now'));
        $form = $this->createForm('AppBundle\Form\Blog_commentType', $blog_comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog_comment);
            $em->flush();

            return $this->redirectToRoute('comment_show', array('id' => $blog_comment->getId()));
        }

        return $this->render('blog_comment/new.html.twig', array(
            'blog_comment' => $blog_comment,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a blog_comment entity.
     *
     * @Route("/{id}", name="comment_show")
     * @Method("GET")
     */
    public function showAction(Blog_comment $blog_comment)
    {
        $deleteForm = $this->createDeleteForm($blog_comment);

        return $this->render('blog_comment/show.html.twig', array(
            'blog_comment' => $blog_comment,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing blog_comment entity.
     *
     * @Route("/edit/{id}", name="comment_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Blog_comment $blog_comment)
    {
        $deleteForm = $this->createDeleteForm($blog_comment);
        $editForm = $this->createForm('AppBundle\Form\Blog_commentType', $blog_comment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comment_edit', array('id' => $blog_comment->getId()));
        }

        return $this->render('blog_comment/edit.html.twig', array(
            'blog_comment' => $blog_comment,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a blog_comment entity.
     *
     * @Route("/{id}", name="comment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Blog_comment $blog_comment)
    {
        $form = $this->createDeleteForm($blog_comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($blog_comment);
            $em->flush();
        }

        return $this->redirectToRoute('comment_index');
    }

    /**
     * Creates a form to delete a blog_comment entity.
     *
     * @param Blog_comment $blog_comment The blog_comment entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Blog_comment $blog_comment)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comment_delete', array('id' => $blog_comment->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
