<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Comment controller.
 *
 * @Route("comment")
 */
class CommentController extends Controller
{
    /**
     * Lists all Comment entities.
     *
     * @Route("/", name="comment_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $BlogComments = $em->getRepository('AppBundle:Comment')->findAll();

        return $this->render('Comment/index.html.twig', array(
            'BlogComments' => $BlogComments,
        ));
    }

    /**
     * Creates a new Comment entity.
     *
     * @Route("/new", name="comment_new")
     * @Method({"GET", "POST"})
     */
    public function createComment(Request $request)
    {
        $BlogComment = new Comment();
        $BlogComment->setCreatedAt(new\DateTime('now'));
        $form = $this->createForm('AppBundle\Form\CommentType', $BlogComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($BlogComment);
            $em->flush();

            return $this->redirectToRoute('comment_show', array('id' => $BlogComment->getId()));
        }

        return $this->render('Comment/new.html.twig', array(
            'Comment' => $BlogComment,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Comment entity.
     *
     * @Route("/{id}", name="comment_show")
     * @Method("GET")
     */
    public function showComment(Comment $BlogComment)
    {
        $deleteForm = $this->createDeleteForm($BlogComment);

        return $this->render('Comment/show.html.twig', array(
            'Comment' => $BlogComment,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Comment entity.
     *
     * @Route("/edit/{id}", name="comment_edit")
     * @Method({"GET", "POST"})
     */
    public function editComment(Request $request, Comment $BlogComment)
    {
        $deleteForm = $this->createDeleteForm($BlogComment);
        $editForm = $this->createForm('AppBundle\Form\CommentType', $BlogComment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comment_edit', array('id' => $BlogComment->getId()));
        }

        return $this->render('Comment/edit.html.twig', array(
            'Comment' => $BlogComment,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Comment entity.
     *
     * @Route("/{id}", name="comment_delete")
     * @Method("DELETE")
     */
    public function deleteComment(Request $request, Comment $BlogComment)
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
     * Creates a form to delete a Comment entity.
     *
     * @param Comment $BlogComment The Comment entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Comment $BlogComment)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comment_delete', array('id' => $BlogComment->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
