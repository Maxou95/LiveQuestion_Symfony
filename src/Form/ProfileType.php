<?php

namespace App\Form;

use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Vich\UploaderBundle\Form\Type\VichImageType;


class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender', ChoiceType::class, [
            'label' => "Genre",
            'choices'  => [
                'Homme' => 'homme',
                'Femme' => 'femme',
                'Non-binaire' => 'non-binaire',
                'Pélican' => 'pélican',
                ],
            ])
            ->add('country')
            ->add('language')
            ->add('description')
            ->add('age')
            ->add('job')
            ->add('address')
            ->add('zipcode')
            ->add('city')
            ->add('firstName')
            ->add('lastName')
            ->add('imageFile', VichImageType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
