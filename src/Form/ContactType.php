<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Your first name'
                ),
            ])
            ->add('lastName', TextType::class, [
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Your last name'
                ),
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Your email'
                ),
            ])
            ->add('message', TextareaType::class, [
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Your message (max 2000 characters)'
                ),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class
        ]);
    }
}
