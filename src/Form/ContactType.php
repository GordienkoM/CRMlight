<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label_format' => 'Prénom',
                'attr' => ['class' => 'uk-input']
            ])
            ->add('lastname', TextType::class, [
                'label_format' => 'Nom',
                'attr' => ['class' => 'uk-input']
            ])
            ->add('email', EmailType::class, [
                "attr" => ['class' => 'uk-input'],
                'label_format' => 'Email',
            ])
            ->add('phone_number', TextType::class, [
                'label_format' => 'Numero de téléphone',
                'attr' => ['class' => 'uk-input']
            ])

        //     ->add('company')
        //     ->add('categories')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
