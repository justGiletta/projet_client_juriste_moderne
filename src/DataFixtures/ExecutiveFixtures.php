<?php

namespace App\DataFixtures;

use App\Entity\Executive;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ExecutiveFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
       // Création d’un executive 1
        $executive1 = new Executive();
        $executive1->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $executive1->setNaturalPerson($this->getReference(NaturalPersonFixtures::NATURAL_PERSON_REFERENCE_1));
        $executive1->setMandateStartdate(new \DateTime('2021-03-23'));
        $executive1->setMandateEnddate(new \DateTime('2025-03-23'));
        $executive1->setMandateType('Président');
        $executive1->setMandateLimitations('Lorem ipsum dolor sit amet consectetur adipisicing elit.');


        $manager->persist($executive1);

        // Création d’un executive 2
        $executive2 = new Executive();
        $executive2->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $executive2->setNaturalPerson($this->getReference(NaturalPersonFixtures::NATURAL_PERSON_REFERENCE_2));
        $executive2->setMandateStartdate(new \DateTime('2019-03-23'));
        $executive2->setMandateEnddate(new \DateTime('2023-03-23'));
        $executive2->setMandateType('Gérant');
        $executive2->setMandateLimitations('Lorem ipsum dolor sit amet consectetur adipisicing elit.');


        $manager->persist($executive2);

        // Création d’un executive 3
        $executive3 = new Executive();
        $executive3->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $executive3->setNaturalPerson($this->getReference(NaturalPersonFixtures::NATURAL_PERSON_REFERENCE_4));
        $executive3->setMandateStartdate(new \DateTime('2020-03-23'));
        $executive3->setMandateEnddate(new \DateTime('2026-03-23'));
        $executive3->setMandateType('Administratrice');
        $executive3->setMandateLimitations('Lorem ipsum dolor sit amet consectetur adipisicing elit.');

        $manager->persist($executive3);

        // Création d’un executive 4
        $executive4 = new Executive();
        $executive4->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $executive4->setNaturalPerson($this->getReference(NaturalPersonFixtures::NATURAL_PERSON_REFERENCE_3));
        $executive4->setMandateStartdate(null);
        $executive4->setMandateEnddate(null);
        $executive4->setMandateType(null);
        $executive4->setMandateLimitations(null);

        $manager->persist($executive4);

        // Création d’un executive 5
        $executive5 = new Executive();
        $executive5->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $executive5->setNaturalPerson($this->getReference(NaturalPersonFixtures::NATURAL_PERSON_REFERENCE_5));
        $executive5->setMandateStartdate(null);
        $executive5->setMandateEnddate(null);
        $executive5->setMandateType(null);
        $executive5->setMandateLimitations(null);

        $manager->persist($executive5);

        // Création d’un executive 6
        $executive6 = new Executive();
        $executive6->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $executive6->setLegalPerson($this->getReference(LegalPersonFixtures::LEGAL_PERSON_REFERENCE_1));
        $executive6->setMandateStartdate(null);
        $executive6->setMandateEnddate(null);
        $executive6->setMandateType(null);
        $executive6->setMandateLimitations(null);

        $manager->persist($executive6);

        // Création d’un executive 7
        $executive7 = new Executive();
        $executive7->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $executive7->setLegalPerson($this->getReference(LegalPersonFixtures::LEGAL_PERSON_REFERENCE_2));
        $executive7->setMandateStartdate(null);
        $executive7->setMandateEnddate(null);
        $executive7->setMandateType(null);
        $executive7->setMandateLimitations(null);


        $manager->persist($executive7);

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
        ];
    }
}
