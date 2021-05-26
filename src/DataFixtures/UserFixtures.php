<?php

namespace App\DataFixtures;

use App\Entity\User;
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
    }
}
