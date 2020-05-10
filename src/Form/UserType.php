<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Email;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => "Nom d'utilisateur :",
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez entrer un nom d'utilisateur",
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => "Votre nom d'utilisateur doit comporter au minimum {{ limit }} caractères",
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => "Adresse email :",
                'constraints' => [
                    new Email(['message' => 'Veuillez saisir une addresse email valide.'])
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au minimum {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
                'first_options' => ['label' => 'Mot de passe :'],
                'second_options' => ['label' => 'Confirmer mot de passe :'],
                'invalid_message' => 'Les mots de passe ne correspondent pas.'
            ])
            ->add('profile', ProfileType::class, [
                'label' => 'Informations suplémentaires (facultatif) :'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
