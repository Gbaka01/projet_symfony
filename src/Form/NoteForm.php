<?php

namespace App\Form;

use App\Entity\Note;
use App\Form\NoteForm;
use App\Entity\Recette;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class NoteForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description1', TextType::class, [
                'label' => 'description1',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
                ])
            ->add('note', IntegerType::class)
            ->add ('recette', EntityType::class, [
                'class' => Recette::class,
                'choice_label' => 'fiche',
            
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
