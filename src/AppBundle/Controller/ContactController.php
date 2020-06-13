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
    public function indexAction(Request $request, \Swift_Mailer $mailer)
    {
        //empty array to catch data from form
        $ourContactFormData=[];

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {

                $ourContactFormData = $form->getData();

                $message = (new \Swift_Message())
                    ->setSubject('Projet 5 - Blog PHP - '.$ourContactFormData['objet'])
                    ->setFrom($ourContactFormData['fromEmail'])
                    ->setTo('reybeka.dev@gmail.com')
                    ->setBody(
                        $this->renderView('contact/email.txt.twig', [
                            'username' => $ourContactFormData['username'],
                            'emailCustomer' => $ourContactFormData['fromEmail'],
                            'content' => $ourContactFormData['message']
                        ]),
                        'text/html'
                    );
                $mailer->send($message);

            }


            //message js type success
            $this->addFlash('success', 'Votre message a bien été envoyé!');
            // redirects to the "contactpage" route
            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'ourContactFormData'=>$ourContactFormData
        ]);

    }
}