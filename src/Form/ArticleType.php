<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'Votre nom']
            ])
            ->add('content', TextareaType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'Votre contenu']
            ])
            ->add('tags', TagsType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'add tag'],
                'label' => false
            ])
            ->add('save', SubmitType::class,[
                'attr' => ['class' => 'btn btn-success'],
                'label' => 'Save'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
