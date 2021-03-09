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

        $user=new User();
        $user->setEmail('administrateur@messagerie.fr')
        ->setUsername('Admin')
        ->setRoles(['ROLE_ADMIN']);
        $password = $this->passwordEncoder->encodePassword($user, "Password");
        $user->setPassword($password);
        $profile = new Profile();
        $profile->setFirstName('Admin')
        ->setLastName('Inistrateur');
        $user->setProfile($profile);

        $manager->persist($user);
        $manager->persist($profile);


        for($i=0; $i<20; $i++){
            $user= new User();
            $user->setEmail($faker->email)
            ->setUsername($faker->userName);

            $password = $this->passwordEncoder->encodePassword($user, "Password");
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
