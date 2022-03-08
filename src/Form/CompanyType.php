<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label_format' => 'Nom de company',
                'attr' => ['class' => 'uk-input']
            ])
            ->add('address', TextType::class, [
                'label_format' => 'Adresse',
                'attr' => ['class' => 'uk-input']
            ])
            ->add('postalCode', TextType::class, [
                'label_format' => 'Code postale',
                'attr' => ['class' => 'uk-input']
            ])
            ->add('city', TextType::class, [
                'label_format' => 'Ville',
                'attr' => ['class' => 'uk-input']
            ])
            ->add('country', TextType::class, [
                'label_format' => 'Pay',
                'attr' => ['class' => 'uk-input']
            ])
            ->add('website', TextType::class, [
                'label_format' => 'Nom de tableau',
                'attr' => ['class' => 'uk-input']
            ])
            // ->add('enable')
            // ->add('creator')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
