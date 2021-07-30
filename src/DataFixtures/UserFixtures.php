<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
       // Création d’un utilisateur de type "user"
        $user = new User();
        $user->setFirstname('Michel');
        $user->setLastname('USER');
        $user->setEmail('user@monsite.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'userpassword'
        ));
        $user->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        ;
        $user->setIsVerified(true);

        $manager->persist($user);

       // Création d’un utilisateur de type “administrateur”
        $admin = new User();
        $admin->setFirstname('Jean-Paul');
        $admin->setLastname('ADMIN');
        $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'adminpassword'
        ));
        $admin->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $admin->setIsVerified(true);

        $manager->persist($admin);

       // Création d’un utilisateur de type “super-administrateur”
        $superadmin = new User();
        $superadmin->setFirstname('Patrick');
        $superadmin->setLastname('SUPERADMIN');
        $superadmin->setEmail('superadmin@monsite.com');
        $superadmin->setRoles(['ROLE_SUPERADMIN']);
        $superadmin->setPassword($this->passwordEncoder->encodePassword(
            $superadmin,
            'superadminpassword'
        ));
        $superadmin->setIsVerified(true);

        $manager->persist($superadmin);


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            StructureFixtures::class,
        ];
    }
}
