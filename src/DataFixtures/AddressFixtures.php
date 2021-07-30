<?php

namespace App\DataFixtures;

use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AddressFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
       // Création d’une addresse 1
        $adress1 = new Address();
        $adress1->addStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $adress1->setAddressStreet('97 allée Théodore Monod');
        $adress1->setAddressComplement('Technopole Izarbel - Estia 2');
        $adress1->setAddressZip('64210');
        $adress1->setAddressCity('BIDART');
        $adress1->setAddressCountry('FRANCE');

        $manager->persist($adress1);

       // Création d’une addresse 2
        $adress2 = new Address();
        $adress2->addNaturalPerson($this->getReference(NaturalPersonFixtures::NATURAL_PERSON_REFERENCE_1));
        $adress2->setAddressStreet('32 allée Théodore Monod');
        $adress2->setAddressComplement('Technopole Babel');
        $adress2->setAddressZip('34210');
        $adress2->setAddressCity('AILLEURS');
        $adress2->setAddressCountry('FRANCE');

        $manager->persist($adress2);

       // Création d’une addresse 3
        $adress3 = new Address();
        $adress3->addNaturalPerson($this->getReference(NaturalPersonFixtures::NATURAL_PERSON_REFERENCE_2));
        $adress3->setAddressStreet('32 rue de l\'Entreprise');
        $adress3->setAddressComplement('Technopole du Droit');
        $adress3->setAddressZip('75004');
        $adress3->setAddressCity('PARIS');
        $adress3->setAddressCountry('FRANCE');

        $manager->persist($adress3);

        // Création d’une addresse 4
        $adress4 = new Address();
        $adress4->addLegalPerson($this->getReference(LegalPersonFixtures::LEGAL_PERSON_REFERENCE_2));
        $adress4->setAddressStreet('16 Quai Ernest Renaud');
        $adress4->setAddressComplement('');
        $adress4->setAddressZip('44100');
        $adress4->setAddressCity('NANTES');
        $adress4->setAddressCountry('FRANCE');

        $manager->persist($adress4);


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CollegeFixtures::class,
            CategoryFixtures::class,
            UserFixtures::class,
            StructureFixtures::class,
            NaturalPersonFixtures::class,
        ];
    }
}
