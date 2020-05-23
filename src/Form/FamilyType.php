<?php

namespace App\Form;

use App\Entity\Family;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class FamilyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label',TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('detail', CollectionType::class,[
                'label'        => 'Détail de la collection',
                'entry_type' => DetailType::class,
                'entry_options' => [
                    'attr' => [
                        'class' => 'item', // we want to use 'tr.item' as collection elements' selector
                    ],
                ],
                'allow_add'    => true,
                'allow_delete' => true,
                'prototype'    => true,
                'required'     => false,
                'by_reference' => false,
                'delete_empty' => true,
                'attr' => [
                    'class' => 'table discount-collection',
                ]
            ])
            ->add('save', SubmitType::class,[
                'attr' => ['class' => 'btn btn-primary'],
                'label' => 'Sauvegarder'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Family::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'FamilyType';
    }
}
