<?php

namespace App\DataFixtures;

use App\Entity\LegalPerson;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LegalPersonFixtures extends Fixture implements DependentFixtureInterface
{
    public const LEGAL_PERSON_REFERENCE_1 = 'legalPerson1';
    public const LEGAL_PERSON_REFERENCE_2 = 'legalPerson2';

    public function load(ObjectManager $manager)
    {
       // Création d’une legal person 1
        $legalPerson1 = new LegalPerson();
        $legalPerson1->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $legalPerson1->setMainRepresentative($this->getReference(NaturalPersonFixtures::NATURAL_PERSON_REFERENCE_4));
        $legalPerson1->setName('SARL Les Constructions Qui Durent');
        $legalPerson1->setSiren('881027722');
        $legalPerson1->setTradeAndCompagnyRegister('VILLE 881 027 722');
        $legalPerson1->setRegisterCapital('2000');
        $legalPerson1->setCompanyForm('SARL');
        $legalPerson1->setEmail('standard@lmds.com');
        $legalPerson1->setTelephone('05 16 85 49 12');
        $legalPerson1->setTelephone2('');

        $manager->persist($legalPerson1);

        // Création d’une legal person 2
        $legalPerson2 = new LegalPerson();
        $legalPerson2->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $legalPerson2->setMainRepresentative($this->getReference(NaturalPersonFixtures::NATURAL_PERSON_REFERENCE_5));
        $legalPerson2->setName('CCI Nantes');
        $legalPerson2->setSiren('130008105');
        $legalPerson2->setTradeAndCompagnyRegister('NANTES 130 008 105');
        $legalPerson2->setRegisterCapital('10000');
        $legalPerson2->setCompanyForm('Etablissement public organisme consulaire');
        $legalPerson2->setEmail('standard@cci-nantes.com');
        $legalPerson2->setTelephone('02 40 44 60 00');
        $legalPerson2->setTelephone2('');

        $manager->persist($legalPerson2);



        $manager->flush();

        $this->addReference(self::LEGAL_PERSON_REFERENCE_1, $legalPerson1);
        $this->addReference(self::LEGAL_PERSON_REFERENCE_2, $legalPerson2);
    }

    public function getDependencies()
    {
        return [
            StructureFixtures::class,
            UserFixtures::class,
            CollegeFixtures::class,
            CategoryFixtures::class,
            NaturalPersonFixtures::class,
        ];
    }
}
