<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\AnswerLike;
use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\Profile;
use App\Entity\Question;
use App\Entity\QuestionLike;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        
        $faker = \Faker\Factory::create('fr_FR');

        $users = [];

        $questions = [];

        $photosQuestion = [
            'questionimagefixtures1.jpg',
            'questionimagefixtures2.jpg',
            'questionimagefixtures3.jpg',
            'questionimagefixtures4.jpg',
            'questionimagefixtures5.jpg',
            'questionimagefixtures6.jpg',
            'questionimagefixtures7.jpg',
            'questionimagefixtures8.jpg',
            'questionimagefixtures9.jpg',
            'questionimagefixtures10.jpg',
            'questionimagefixtures11.jpg',
            'questionimagefixtures12.jpg',
            'questionimagefixtures13.jpg',
            'questionimagefixtures14.jpg',
            'questionimagefixtures15.jpg',
            'questionimagefixtures16.jpg',
            'questionimagefixtures17.jpg',
            'questionimagefixtures18.jpg',
            'questionimagefixtures19.jpg',
            'questionimagefixtures20.jpg'
        ];

        $photosUser = [
            'userimagefixtures1.jpg',
            'userimagefixtures2.jpg',
            'userimagefixtures3.jpg',
            'userimagefixtures4.jpg',
            'userimagefixtures5.jpg',
            'userimagefixtures6.jpg',
            'userimagefixtures7.jpg',
            'userimagefixtures8.jpg',
            'userimagefixtures9.jpg',
            'userimagefixtures10.jpg',
            'userimagefixtures11.jpg',
            'userimagefixtures12.jpg',
            'userimagefixtures13.jpg',
            'userimagefixtures14.jpg',
            'userimagefixtures15.jpg',
            'userimagefixtures16.jpg',
            'userimagefixtures17.jpg',
            'userimagefixtures18.jpg',
            'userimagefixtures19.jpg',
            'userimagefixtures20.jpg',
        ];

        $categories = [
            'Animaux',
            'Architechture, ville, urbanisme',
            'Art et culture',
            'Cadeaux, objet',
            'Cinéma, télévision, médias',
            'Commerces et services de proximités',
            'Communication, marketing, identité visuelle',
            'Création, arts graphiques, photo',
            'Education, études, formation',
            'Entreprise, business, économie',
            'High-tech, informatique, internet',
            'Humour',
            'Jeux vidéos, gaming',
            'Maison, déco, design',
            'Mode, look, style, tendance',
            'Musique',
            'Nature, environnement, écologie',
            'Nourriture, gastronomie, alimentation',
            'Passions, loisirs, hobbies',
            'Personalité publique',
            'Personnel, vie privée',
            'Philosophie, éthique, morale',
            'Santé, soins, bien-être',
            'Science, recherche et technologie',
            'Société, politique, vie publique',
            'Sport',
            'Vacances, voyage, tourisme',
            'Véhicule, moyen de transport',
            'Autre',
        ];

        $user=new User();
        $user->setEmail('administrateur@livequestion.fr')
        ->setUsername('LiveQuestion')
        ->setRoles(['ROLE_ADMIN']);
        $password = $this->passwordEncoder->encodePassword($user, "QuestionLive");
        $user->setPassword($password);
        $profile = new Profile();
        $profile->setFirstName('Live')
        ->setLastName('Question');
        $user->setProfile($profile);

        $manager->persist($user);
        $manager->persist($profile);


        for($i=0; $i<20; $i++){
            $user= new User();
            $user->setEmail($faker->email)
            ->setUsername($faker->userName);

            $password = $this->passwordEncoder->encodePassword($user, "password");
            $user->setPassword($password);

            $manager->persist($user);

            

            $profile= new Profile();
            $profile->setFirstName($faker->firstName)
            ->setLastName($faker->lastName)
            ->setAddress($faker->streetAddress)
            ->setZipcode(mt_rand(10000,90000))
            ->setCity($faker->city)
            ->setCountry('France')
            ->setAge(mt_rand(18,100))
            ->setDescription($faker->sentence(mt_rand(2,15)))
            ->setGender($faker->title)
            ->setJob($faker->jobTitle)
            ->setLanguage('Français')
            ->setFixturesImageName($photosUser[$i])
            ->setUser($user);

            $manager->persist($profile);

            $this->users[] = $user;

            for($j=0; $j<mt_rand(0,20); $j++)
            {
                $question = new Question();
                $question->setQuestion(rtrim($faker->sentence(mt_rand(5,15)),'.').' ?')
                ->setViews(mt_rand(10,300))
                ->setCategory($categories[mt_rand(0,28)])
                ->setCreated($faker->dateTimeThisMonth)
                ->setUser($user)
                ->setUpdatedAt($faker->dateTimeThisMonth);

                if (mt_rand(0,2) == 0)
                {
                    $question->setFixturesImageName($photosQuestion[$j]);
                }

                $manager->persist($question);

                $this->questions[]=$question;
            }
        }

        for($k=0; $k<mt_rand(300,500); $k++)
        {
            $answer = new Answer();
            $answer->setQuestion($this->questions[mt_rand(0, count($this->questions)-1)])
            ->setUser($this->users[mt_rand(0, count($this->users)-1)])
            ->setCreated($faker->dateTimeThisMonth)
            ->setBody($faker->sentence(mt_rand(5,15)));

            $manager->persist($answer);

            $answerLike = new AnswerLike();
            $answerLike->setAnswer($answer)
            ->setUser($this->users[mt_rand(0, count($this->users)-1)]);

            $manager->persist($answerLike);

            $questionLike = new QuestionLike();
            $questionLike->setQuestion($this->questions[mt_rand(0, count($this->questions)-1)])
            ->setUser($this->users[mt_rand(0, count($this->users)-1)]);
            
            $manager->persist($questionLike);
        }

        for($m=0; $m<50; $m++)
        {
            $participants = [];

            $conversation = new Conversation();
            $conversation->setName($faker->sentence(4))
            ->setCreated($faker->dateTimeThisMonth);
            
            for ($n=0; $n<mt_rand(1,6); $n++)
            {
                $conversation->addParticipant($participant = $this->users[mt_rand(0, count($this->users)-1)]);
                $participants[]=$participant;
            }

            $manager->persist($conversation);

            for($p=0; $p<mt_rand(2,25); $p++)
            {
            $message = new Message();
            $message->setSender($participants[mt_rand(0, count($participants)-1)])
            ->setCreated($faker->dateTimeThisMonth)
            ->setBody($faker->sentence(mt_rand(5,20)))
            ->setConversation($conversation);
            
            $manager->persist($message);
            }

            
        }

        $manager->flush();
    }
}
