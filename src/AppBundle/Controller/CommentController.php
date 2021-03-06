<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Comment controller.
 *
 * @Route("admin/comment")
 * @IsGranted("ROLE_ADMIN", message="Accès administrateur, veuillez-vous connecter!")
 *
 */
class CommentController extends Controller
{
    /**
     * Lists all Comment entities.
     *
     * @Route("/", name="comment_index")
     *
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        //display all comment in back-end manager
        $comments = $em->getRepository('AppBundle:Comment')->findAll();

        return $this->render('Comment/index.html.twig', array(
            'comments' => $comments,
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

        return $this->render('comment/new.html.twig', array(
            'Comment' => $BlogComment,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Comment entity.
     *
     * @Route("-{id}", name="comment_show")
     * @Method("GET")
     */
    public function showComment(Comment $comment)
    {
        $deleteForm = $this->createDeleteForm($comment);

        return $this->render('comment/show.html.twig', array(
            'comment' => $comment,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Comment entity.
     *
     * @Route("/edit-{id}", name="comment_edit")
     * @Method({"GET", "POST"})
     */
    public function editComment(Request $request, Comment $comment)
    {
        $deleteForm = $this->createDeleteForm($comment);
        $editForm = $this->createForm('AppBundle\Form\CommentType', $comment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comment_edit', array('id' => $comment->getId()));
        }

        return $this->render('Comment/edit.html.twig', array(
            'comment' => $comment,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Comment entity.
     *
     * @Route("-{id}", name="comment_delete")
     * @Method("DELETE")
     */
    public function deleteComment(Request $request, Comment $comment)
    {
        $form = $this->createDeleteForm($comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();
        }

        return $this->redirectToRoute('comment_index');
    }

    /**
     * @param Comment $comment
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Comment $comment)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comment_delete', array('id' => $comment->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * @Route("/approved/{id}", name="comment_approved")
     */
    public function approvedComment(Request $request, Comment $comment)
    {
        $em = $this->getDoctrine()->getManager();
        $comment->setApproved(true);
        $em->persist($comment);
        $em->flush();

        return $this->redirectToRoute('comment_index');
    }

    /**
     * @Route("/unapproved/{id}", name="comment_unapproved")
     */
    public function unApprovedComment(Request $request, Comment $comment)
    {
        $em = $this->getDoctrine()->getManager();
        $comment->setApproved(false);
        $em->persist($comment);
        $em->flush();

        return $this->redirectToRoute('comment_index');
    }
}
