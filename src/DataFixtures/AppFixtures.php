<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Profile;
use App\Entity\Question;
use App\Entity\QuestionLike;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        
        $faker = \Faker\Factory::create('fr_FR');

        $users = [];

        $questions = [];

        for($i=0; $i<30; $i++){
            $user= new User();
            $user->setEmail($faker->email)
            ->setPassword('password')
            ->setUsername($faker->userName);

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
            ->setImageFile()
            ->setUser($user);

            $manager->persist($profile);

            $this->users[] = $user;

            for($j=0; $j<mt_rand(0,10); $j++)
            {
                $question = new Question();
                $question->setQuestion($faker->sentence(mt_rand(5,15)).'?')
                ->setViews(mt_rand(10,300))
                ->setCategory('Autres')
                ->setCreated($faker->dateTimeThisMonth)
                ->setUser($user);

                $manager->persist($question);

                $this->questions[]=$question;
            }
        }

        for($k=0; $k<mt_rand(100,500); $k++)
        {
            $answer = new Answer();
            $answer->setQuestion($this->questions[mt_rand(0, count($this->questions)-1)])
            ->setUser($this->users[mt_rand(0, count($this->users)-1)])
            ->setCreated($faker->dateTimeThisMonth)
            ->setBody($faker->sentence(mt_rand(5,15)));

            $manager->persist($answer);

            $questionLike = new QuestionLike();
            $questionLike->setQuestion($this->questions[mt_rand(0, count($this->questions)-1)])
            ->setUser($this->users[mt_rand(0, count($this->users)-1)]);
            
            $manager->persist($questionLike);
        }
        $manager->flush();
    }
}
