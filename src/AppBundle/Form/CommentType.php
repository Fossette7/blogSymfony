<?php

namespace AppBundle\Form;

use AppBundle\Entity\Comment;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CommentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('author', TextType::class, [
                'label' => 'Pseudo',
                'attr' => ['class' => 'form-control']
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Message',
                'attr' => ['class' => 'form-control']
            ])
            ->add('Envoyer', SubmitType::class
            )
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                // Check error on my form
                // Get My form
                $form = $event->getForm();

                // Get content field on my form
                $contentFieldObject = $form->get('content');

                // Check if content is not empty
                if(strlen(trim($contentFieldObject->getData())) < 10)
                {
                    // Set error on content field
                    $contentFieldObject->addError(new FormError('Votre commentaire doit faire au minimum 10 charactères'));
                }
            });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_comment';
    }


}
