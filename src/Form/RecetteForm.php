<?php

namespace App\Form;

use App\Entity\Recette;
use App\Entity\Categorie;
use App\Form\RecetteForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RecetteForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description4', TextareaType::class, [
                'label' => 'description4',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
                ])
            ->add('fiche', TextType::class, [
                'label' => 'fiche',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
                ])
            ->add('avatar1', FileType::class, [
                'label' => 'avatar1',
                'mapped' => false,
                'required' => false,
                    ])
            ->add('categories', EntityType::class, [
                'multiple' => true,
                'choice_label' => 'description2',
                'expanded' => true,
                'class' => Categorie::class,
            ])        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }
}
