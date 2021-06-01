<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = new User();
        $user 
            ->setFirstname('Thomas')
            ->setLastname('Poinsignon')
            ->setEmail('thomas.poinsignon@stagiairesifa.fr')
            ->setBirthAt(new \DateTime(''))
            ->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'azerty'
            ))
            ->setRoles(['ROLE_ADMIN'])
            ->setIsValidate(true)
        ;

        $manager->persist($user);
        $manager->flush();




        $faker = Factory::create('fr_FR'); /* faker permet d'initier des champs aleatoire ;  composer require fzaninotto/faker   */
        $users = [];
        for($i = 0; $i < 30; $i++)
        {
            $newUser = new User();
            $newUser 
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setEmail($faker->email())
                ->setBirthAt(new \DateTime())
                ->setPassword($this->passwordEncoder->encodePassword(
                    $newUser,
                    'azerty'
                ))
                ->setRoles(['ROLE_USER'])
                ->setIsValidate(true)
            ;
            $manager->persist($newUser);
            $users[] = $newUser;

        }
        $manager->flush();


        /* creation des post */
        $tabPost = [];
        for($i = 0; $i < 100; $i++)
        {
            $newPost = new Post();
            $newPost
                ->setContent($faker->realText())
                ->setPublishedAt(new \DateTime())
                ->setUser($faker->randomElement($users));
            $manager->persist($newPost);
            $tabPost[] = $newPost; 
        }
        $manager->flush();


        // creation des commentaires
        for($i = 0; $i < 200; $i++)
        {
            $newComment = new Comment();
            $newComment
                ->setContent($faker->realText())
                ->setCreatedAt(new \DateTime())
                ->setPost($faker->randomElement($tabPost))
                ->setUser($faker-> randomElement($users));
            $manager->persist($newComment);  
        }
        $manager->flush();
    }
}
