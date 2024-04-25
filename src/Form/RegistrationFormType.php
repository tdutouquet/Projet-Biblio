<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => 'form-control mb-2'
                ],
                'label' => false,
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => 'form-control mb-2'
                ],
                'label' => false,
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Prénom',
                    'class' => 'form-control mb-2'
                ],
                'label' => false,
            ])
            ->add('phone', TelType::class, [
                'attr' => [
                    'placeholder' => 'Téléphone',
                    'class' => 'form-control mb-2'
                ],
                'label' => false,
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'placeholder' => 'Adresse',
                    'class' => 'form-control mb-2'
                ],
                'label' => false,
            ])
            ->add('zipcode', TextType::class, [
                'attr' => [
                    'placeholder' => 'Code postal',
                    'class' => 'form-control mb-2'
                ],
                'label' => false,
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ville',
                    'class' => 'form-control mb-2'
                ],
                'label' => false,
            ])
            ->add('birthdate', BirthdayType::class, [
                'attr' => [
                    'class' => 'form-control mb-2'
                ],
                'label' => 'Date de naissance',
                'label_attr' => [
                    'class' => 'mt-2 text-body-tertiary'
                ],
                'widget' =>'single_text',
            ])
            ->add('consent', CheckboxType::class, [
                'mapped' => false,
                'row_attr' => [
                    'class' => 'form-check mt-4'
                ],
                'label_attr' => [
                    'class' => 'form-check-label'
                ],
                'attr' => [
                    'class' =>'form-check-input'
                ],
                'label' => 'J\'accepte les CGV',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les CGV pour vous inscrire',
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les champs de mot de passe ne correspondent pas.',
                'options' => [
                    'attr' => ['class' => 'form-control'],
                    'required' => true,
                    'label' => false,
                ],
                'required' => true,
                'first_options'  => ['attr' => ['placeholder' => 'Mot de passe']],
                'second_options' => ['attr' => ['placeholder' => 'Confirmation du mot de passe']],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ]
            ])
            // ->add('plainPassword', PasswordType::class, [
            //     // instead of being set onto the object directly,
            //     // this is read and encoded in the controller
            //     'mapped' => false,
            //     'attr' => [
            //         'autocomplete' => 'new-password',
            //         'placeholder' => 'Mot de passe',
            //         'class' => 'form-control'
            //     ],
            //     'constraints' => [
            //         new NotBlank([
            //             'message' => 'Please enter a password',
            //         ]),
            //         new Length([
            //             'min' => 6,
            //             'minMessage' => 'Your password should be at least {{ limit }} characters',
            //             // max length allowed by Symfony for security reasons
            //             'max' => 4096,
            //         ]),
            //     ],
            //     'label' => false,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
