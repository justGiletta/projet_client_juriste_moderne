<?php

namespace App\DataFixtures;

use App\Entity\OtherParticipant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OtherParticipantFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
       // Création d’un otherParticipant 1
        $otherParticipant1 = new OtherParticipant();
        $otherParticipant1->setOtherParticipantRole('Invité');
        $otherParticipant1->setNaturalPerson($this->getReference(NaturalPersonFixtures::NATURAL_PERSON_REFERENCE_5));

        $manager->persist($otherParticipant1);

        // Création d’un otherParticipant 2
        $otherParticipant2 = new OtherParticipant();
        $otherParticipant2->setNaturalPerson($this->getReference(NaturalPersonFixtures::NATURAL_PERSON_REFERENCE_1));

        $manager->persist($otherParticipant2);

        // Création d’un otherParticipant 3
        $otherParticipant3 = new OtherParticipant();
        $otherParticipant3->setNaturalPerson($this->getReference(NaturalPersonFixtures::NATURAL_PERSON_REFERENCE_2));

        $manager->persist($otherParticipant3);

        // Création d’un otherParticipant 4
        $otherParticipant4 = new OtherParticipant();
        $otherParticipant4->setNaturalPerson($this->getReference(NaturalPersonFixtures::NATURAL_PERSON_REFERENCE_3));

        $manager->persist($otherParticipant4);

        // Création d’un otherParticipant 5
        $otherParticipant5 = new OtherParticipant();
        $otherParticipant5->setNaturalPerson($this->getReference(NaturalPersonFixtures::NATURAL_PERSON_REFERENCE_4));

        $manager->persist($otherParticipant5);

        // Création d’un otherParticipant 6
        $otherParticipant6 = new OtherParticipant();
        $otherParticipant6->setLegalPerson($this->getReference(LegalPersonFixtures::LEGAL_PERSON_REFERENCE_1));

        $manager->persist($otherParticipant6);

        // Création d’un otherParticipant 7
        $otherParticipant7 = new OtherParticipant();
        $otherParticipant7->setLegalPerson($this->getReference(LegalPersonFixtures::LEGAL_PERSON_REFERENCE_2));

        $manager->persist($otherParticipant7);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            StructureFixtures::class,
            UserFixtures::class,
            CollegeFixtures::class,
            CategoryFixtures::class,
            NaturalPersonFixtures::class,
            LegalPersonFixtures::class,
            ExecutiveFixtures::class,
            AssociateFixtures::class,
        ];
    }
}
