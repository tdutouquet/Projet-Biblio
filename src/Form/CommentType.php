<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => 'Votre commentaire (500 caractères) :',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'maxlength' => '500'
                ]
            ])
            ->add('rating', RangeType::class, [
                'label' => 'Note (entre 0 et 5) :',
                'required' => true,
                'attr' => [
                    'class' => 'form-range',
                    'min' => '0',
                    'max' => '5', 
                    'step' => '1',
                    'oninput' => 'this.nextElementSibling.value = this.value'
                ]
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn btn-primary',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
