<?php

namespace App\DataFixtures;

use App\Entity\Structure;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StructureFixtures extends Fixture
{
    public const STRUCTURE_REFERENCE_1 = 'structure1';

    public function load(ObjectManager $manager)
    {
       // Création d’une structure
        $structure1 = new Structure();
        $structure1->setName('CONSULTANT YC');
        $structure1->setSiren('881027700');
        $structure1->setTradeAndCompanyRegister('BAYONNE 881 027 700');
        $structure1->setRegisteredCapital('8000');
        $structure1->setCompanyForm('Entreprise individuelle');
        $structure1->setShareUnitValue('200');
        $structure1->setEmail('projet.ykcr@gmail.com');
        $structure1->setTelephone('06 16 83 49 52');
        $structure1->setTelephone2('01 50 50 50 50');
        $structure1->setDescription(
            'CONSULTANT YC vous accompagne dans vos projets de création et de développement d\'entreprise.
            Vous bénéficiez de notre expérience dans le domaine de l\'innovation.'
        );
        $structure1->setEmail('projet.ykcr@gmail.com');

        $manager->persist($structure1);


        $manager->flush();

        $this->addReference(self::STRUCTURE_REFERENCE_1, $structure1);
    }
}
