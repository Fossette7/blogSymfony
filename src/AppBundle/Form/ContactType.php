<?php
/**
 * Created by PhpStorm.
 * User: bricepeyrat
 * Date: 03/05/2020
 * Time: 18:35
 */

namespace AppBundle\Form;


use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add('nom', TextType::class, array('required' => true))
           ->add('email', EmailType::class, array('required' => true))
           ->add('objet', TextType::class, array('required' => true))
           ->add('message', TextareaType::class, array('required' => true,
               'constraints' => array(new NotBlank(),
                   new length(array('min'=> 3))
                   )));

    }
}