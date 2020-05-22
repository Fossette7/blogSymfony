<?php
/**
 * Created by PhpStorm.
 * User: bricepeyrat
 * Date: 03/05/2020
 * Time: 19:07
 */

namespace AppBundle\Controller;


use AppBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("contact")
 *
 */

class ContactController extends Controller
{
    /**
     * @Route("/", name="contact")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        //dump($form->isValid());
       // dump($form->getData());
        //dump($request->request->all());
        //die();
        if ($form->isSubmitted() && $form->isValid()) {
            //message js type success
            $this->addFlash('success', 'Votre message a bien été envoyé');
            // redirects to the "contactpage" route
            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}