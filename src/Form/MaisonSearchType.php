<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaisonSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pieces', IntegerType::class, [
                'required' => false
            ])
            ->add('chambres', IntegerType::class, [
                'required' => false
            ])
            ->add('surface', IntegerType::class, [
                'required' => false
            ])
            ->add('budget', IntegerType::class, [
                'required' => false
            ])
            ->add('Chercher', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
