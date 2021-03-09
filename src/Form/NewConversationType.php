<?php

namespace App\Form;

use App\Entity\Conversation;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class NewConversationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom de la conversation",
            ])
            ->add('participants', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
                'multiple' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Créer la conversation",
                'attr' => ['class' => 'btn-instantmessage full-width']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Conversation::class,
        ]);
    }
}
