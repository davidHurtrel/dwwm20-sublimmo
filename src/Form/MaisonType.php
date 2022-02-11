<?php

namespace App\Form;

use App\Entity\Commercial;
use App\Entity\Maison;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Image;

class MaisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Titre',
                'attr' => [
                    'maxLength' => 100,
                    'placeholder' => 'Ex.: jolie maison de campagne'
                ]
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => 'Description',
                'attr' => [
                    'maxLength' => 65535,
                    'placeholder' => 'Ex.: maison de campagne en bordure de rivière avec grand jardin...'
                ]
            ])
            ->add('surface', IntegerType::class, [
                'required' => true,
                'label' => 'Surface (m2)',
                'attr' => [
                    'min' => 0,
                    'max' => 999,
                    'placeholder' => 'Ex.: 100'
                ]
            ])
            ->add('rooms', IntegerType::class, [
                'required' => true,
                'label' => 'Pièces',
                'attr' => [
                    'min' => 0,
                    'max' => 99,
                    'placeholder' => 'Ex.: 8'
                ]
            ])
            ->add('bedrooms', IntegerType::class, [
                'required' => true,
                'label' => 'Chambres',
                'attr' => [
                    'min' => 0,
                    'max' => 99,
                    'placeholder' => 'Ex.: 4'
                ]
            ])
            ->add('price', IntegerType::class, [
                'required' => true,
                'label' => 'Prix (€)',
                'attr' => [
                    'min' => 0,
                    'max' => 9999999,
                    'placeholder' => 'Ex.: 123 456'
                ]
            ])
            ->add('img1', FileType::class, [
                'required' => false,
                'label' => 'Photo principale',
                'mapped' => false,
                'help' => 'png, jpg, jpeg, jp2 ou webp - 1 Mo maximum',
                'constraints' => [
                    new Image([
                        'maxSize' => '1M',
                        'maxSizeMessage' => 'Le fichier est trop volumineux ({{ size }} Mo). Maximum autorisé : {{ limit }} Mo.',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                            'image/jp2',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Merci de sélectionner une image au format PNG, JPG, JPEG, JP2 ou WEBP'
                    ])
                ]
            ])
            ->add('img2', FileType::class, [
                'required' => false,
                'label' => 'Photo secondaire',
                'mapped' => false,
                'help' => 'png, jpg, jpeg, jp2 ou webp - 1 Mo maximum',
                'constraints' => [
                    new Image([
                        'maxSize' => '1M',
                        'maxSizeMessage' => 'Le fichier est trop volumineux ({{ size }} Mo). Maximum autorisé : {{ limit }} Mo.',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                            'image/jp2',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Merci de sélectionner une image au format PNG, JPG, JPEG, JP2 ou WEBP'
                    ])
                ]
            ])
            ->add('commercial', EntityType::class, [
                'required' => true,
                'class' => Commercial::class,
                'choice_label' => 'name'
            ])
            // ->add('envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Maison::class,
        ]);
    }
}
