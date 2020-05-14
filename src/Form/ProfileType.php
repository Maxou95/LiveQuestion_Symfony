<?php

namespace App\Form;

use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;


class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom :',
                'required'   => false,
                'empty_data' => null,
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom de famille :',
                'required'   => false,
                'empty_data' => null,
            ])
            ->add('gender', ChoiceType::class, [
            'label' => "Genre :",
            'choices'  => [
                'Homme' => 'homme',
                'Femme' => 'femme',
                'Non-binaire' => 'non-binaire',
                ],
                'required'   => false,
                'empty_data' => null,
            ])
            ->add('description', TextareaType::class, [
                'label' => "Description :",
                'required'   => false,
                'empty_data' => null,
            ])
            ->add('age', IntegerType::class, [
                'label' => "Age :",
                'required'   => false,
                'empty_data' => '0',
            ])
            ->add('job', TextType::class, [
                'label' => 'Profession :',
                'required'   => false,
                'empty_data' => null,
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse :',
                'required'   => false,
                'empty_data' => null,
            ])
            ->add('zipcode', TextType::class, [
                'label' => 'Code postal :',
                'required'   => false,
                'empty_data' => null,
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville :',
                'required'   => false,
                'empty_data' => null,
            ])
            ->add('country', CountryType::class, [
                'label' => "Pays",
                'required'   => false,
                'empty_data' => null,
            ])
            ->add('language', LanguageType::class, [
                'label' => "Langue",
                'required'   => false,
                'empty_data' => null,
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Photo de profil :',
                'required'   => false,
                'empty_data' => null,
                'delete_label' => "Supprimer l'image",
                'download_label' => ''
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
