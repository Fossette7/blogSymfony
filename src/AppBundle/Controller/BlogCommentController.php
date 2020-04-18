<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BlogComment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * BlogComment controller.
 *
 * @Route("comment")
 */
class BlogCommentController extends Controller
{
    /**
     * Lists all BlogComment entities.
     *
     * @Route("/", name="comment_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $BlogComments = $em->getRepository('AppBundle:BlogComment')->findAll();

        return $this->render('BlogComment/index.html.twig', array(
            'BlogComments' => $BlogComments,
        ));
    }

    /**
     * Creates a new BlogComment entity.
     *
     * @Route("/new", name="comment_new")
     * @Method({"GET", "POST"})
     */
    public function createComment(Request $request)
    {
        $BlogComment = new BlogComment();
        $BlogComment->setCreatedAt(new\DateTime('now'));
        $form = $this->createForm('AppBundle\Form\BlogCommentType', $BlogComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($BlogComment);
            $em->flush();

            return $this->redirectToRoute('comment_show', array('id' => $BlogComment->getId()));
        }

        return $this->render('BlogComment/new.html.twig', array(
            'BlogComment' => $BlogComment,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a BlogComment entity.
     *
     * @Route("/{id}", name="comment_show")
     * @Method("GET")
     */
    public function showComment(BlogComment $BlogComment)
    {
        $deleteForm = $this->createDeleteForm($BlogComment);

        return $this->render('BlogComment/show.html.twig', array(
            'BlogComment' => $BlogComment,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing BlogComment entity.
     *
     * @Route("/edit/{id}", name="comment_edit")
     * @Method({"GET", "POST"})
     */
    public function editComment(Request $request, BlogComment $BlogComment)
    {
        $deleteForm = $this->createDeleteForm($BlogComment);
        $editForm = $this->createForm('AppBundle\Form\BlogCommentType', $BlogComment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comment_edit', array('id' => $BlogComment->getId()));
        }

        return $this->render('BlogComment/edit.html.twig', array(
            'BlogComment' => $BlogComment,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a BlogComment entity.
     *
     * @Route("/{id}", name="comment_delete")
     * @Method("DELETE")
     */
    public function deleteComment(Request $request, BlogComment $BlogComment)
    {
        $form = $this->createDeleteForm($BlogComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($BlogComment);
            $em->flush();
        }

        return $this->redirectToRoute('comment_index');
    }

    /**
     * Creates a form to delete a BlogComment entity.
     *
     * @param BlogComment $BlogComment The BlogComment entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BlogComment $BlogComment)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comment_delete', array('id' => $BlogComment->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
