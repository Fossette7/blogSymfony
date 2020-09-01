<?php
/**
 * Created by PhpStorm.
 * User: bricepeyrat
 * Date: 03/05/2020
 * Time: 18:35
 */

namespace AppBundle\Form;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormEvents;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add('username', TextType::class, array(
               'required' => true,
               'label'=>'Pseudo',
               ))
           ->add('fromEmail', EmailType::class, [
               'required' => true,
                'label'=>'E-mail'])
           ->add('objet', TextType::class, array('required' => true))
           ->add('message', TextareaType::class, array('required' => true,
               'constraints' => array(new NotBlank(),
                   new Length(array('min'=> 3))
                   )))
           ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
               // Check error on my form
               // Get My form
               $form = $event->getForm();
               // Get content field on my form
               $contentFieldObject = $form->get('message');
               //check message send

           });

    }
}