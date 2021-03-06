<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author', TextType::class, [
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Your name'
                ),
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Your email'
                ),
            ])
            ->add('content', TextareaType::class, [
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Your comment (max 500 characters)',
                    'rows' => '3',
                ),
            ])
            //->add('createdAt')
            //->add('updatedAt')
            //->add('post')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
