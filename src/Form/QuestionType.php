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
                    'CO' => 'Cadeaux, objet',
                    'CTM' => 'Cinéma, télévision, médias',
                    'CSP' => 'Commerces et services de proximités',
                    'CMI' => 'Communication, markting, identité visuelle',
                    'CAP' => 'Création, arts graphiques, photo',
                    'EEF' => 'Education, études, formation',
                    'EBE' => 'Entreprise, business, économie',
                    'HII' => 'High-tech, informatique, internet',
                    'H' => 'Humour',
                    'JV' => 'Jeux vidéos, gaming',
                    'MDD' => 'Maison, déco, design',
                    'MLST' => 'Mode, look, style, tendance',
                    'M' => 'Musique',
                    'NEE' => 'Nature, environnement, écologie',
                    'NGA' => 'Nourriture, gastronomie, alimentation',
                    'PLH' => 'Passions, loisirs, hobbies',
                    'PP' => 'Personalité publique',
                    'PVP' => 'Personnel, vie privée',
                    'PEM' => 'Philosophie, éthique, morale',
                    'SSBE' => 'Santé, soins, bien-être',
                    'SRT' => 'Science, recherche et technologie',
                    'SPVP' => 'Société, politique, vie publique',
                    'S' => 'Sport',
                    'VVT' => 'Vacances, voyage, tourisme',
                    'VMT' => 'Véhicule, moyen de transport',
                    'Z' => 'Autre',
                ],
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
