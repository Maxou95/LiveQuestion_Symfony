<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Votre question ne doit pas etre vide.'
                    ]),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Votre question ne doit pas dépasser {{ limit }} caractères.'
                    ])
                ]
            ])
            ->add('category', ChoiceType::class, [
                'label' => "Catégorie",
                'choices'  => [
                    'Animaux' => 'Animaux',
                    'Architechture, ville, urbanisme' => 'Architechture, ville, urbanisme',
                    'Art et culture' => 'Art et culture',
                    'Cadeaux, objet' => 'Cadeaux, objet',
                    'Cinéma, télévision, médias' => 'Cinéma, télévision, médias',
                    'Commerces et services de proximités' => 'Commerces et services de proximités',
                    'Communication, markting, identité visuelle' => 'Communication, markting, identité visuelle',
                    'Création, arts graphiques, photo' => 'Création, arts graphiques, photo',
                    'Education, études, formation' => 'Education, études, formation',
                    'Entreprise, business, économie' => 'Entreprise, business, économie',
                    'High-tech, informatique, internet' => 'High-tech, informatique, internet',
                    'Humour' => 'Humour',
                    'Jeux vidéos, gaming' => 'Jeux vidéos, gaming',
                    'Maison, déco, design' => 'Maison, déco, design',
                    'Mode, look, style, tendance' => 'Mode, look, style, tendance',
                    'Musique' => 'Musique',
                    'Nature, environnement, écologie' => 'Nature, environnement, écologie',
                    'Nourriture, gastronomie, alimentation' => 'Nourriture, gastronomie, alimentation',
                    'Passions, loisirs, hobbies' => 'Passions, loisirs, hobbies',
                    'Personalité publique' => 'Personalité publique',
                    'Personnel, vie privée' => 'Personnel, vie privée',
                    'Philosophie, éthique, morale' => 'Philosophie, éthique, morale',
                    'Santé, soins, bien-être' => 'Santé, soins, bien-être',
                    'Science, recherche et technologie' => 'Science, recherche et technologie',
                    'Société, politique, vie publique' => 'Société, politique, vie publique',
                    'Sport' => 'Sport',
                    'Vacances, voyage, tourisme' => 'Vacances, voyage, tourisme',
                    'Véhicule, moyen de transport' => 'Véhicule, moyen de transport',
                    'Autre' => 'Autre',
                ],
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => "Photo d'illustration",
                'required'   => false,
                'empty_data' => null,
                'delete_label' => "Supprimer l'image",
                'download_label' => ''
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Poser votre question"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
