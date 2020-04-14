<?php

namespace AppBundle\Form;

use AppBundle\Entity\Blog_comment;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Blog_commentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr'=> [
                    'class'=>'form-control'
                ]
            ])
            ->add('author', TextType::class, [
                'label'=> 'Pseudo',
                'attr' => ['class' =>'form-control']
            ])
            ->add('content', TextareaType::class,[
                'label'=> 'Message',
                'attr' => ['class' =>'form-control']
            ])
            ->add('Envoyer', SubmitType::class
            )
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Blog_comment::class,
                ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_blog_comment';
    }



}
