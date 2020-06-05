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
    public function indexAction(Request $request)// \Swift_Mailer $mailer)
    {
        $ourContactFormData=[];
        //$this->mailer = $mailer;

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        //dump($form->isValid());
       // dump($form->getData());
        //dump($request->request->all());
        //die();
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {

                $ourContactFormData = $form->getData();

              /*  $message = \Swift_Message::newInstance('Our Code World Newsletter')
                    ->setSubject(array($ourContactFormData['$objet'])) //objet du mail
                    ->setFrom(array($ourContactFormData['$email'] => $ourContactFormData['$nom']))  //nom de l'expéditeur et
                    //    normalement le mail saisie
                    ->setReplyTo(array($ourContactFormData['$email']))  // répondre à la personne qui envoie avec le mail saisie
                    // car sans ela si on fait
                    // répondre y a rien
                    ->setTo('reybeka.peyrat@gmail.com') //mail qui reçoit le message
                    ->setBody("<h1>$msg,<br/> Envoyé par : $email</h1>", 'text/html'); */

               // $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')->setUsername('mymail@gmail.com')->setPassword('mypassword');

                //$mailer = \Swift_Mailer::newInstance($transport);
                $mailer = $this->get('mailer');
                $message = \Swift_Message::newInstance('Our Code World Newsletter')
                    ->setFrom(array('mymail@gmail.com' => 'Our Code World'))
                    ->setReplyTo(array("mail@email.com" => "mail@mail.com"))
                    ->setBody("<h1>Welcome</h1>", 'text/html');
                $result = $mailer->send($message);



                //$this->get('mailer')->send($message);
die('OK');

            }


            //message js type success
            $this->addFlash('success', 'Votre message a bien été envoyé');
            // redirects to the "contactpage" route
            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'ourContactFormData'=>$ourContactFormData
        ]);

    }
}