<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

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
            ->add('categories', EntityType::class, [
                'label_format' => 'Catégorie',
                'class'         => Category::class,
                'choice_label'  => 'name',
                'attr'          => ['class' => 'uk-input'],
                //permet d'afficher plusieurs categories dans un champ
                'multiple'      => true,
                //pour selectioner plusier categorie pour le tableau
                'expanded'      => true, 
                // 'by_reference' => false,             
                ])

        //     ->add('company')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
