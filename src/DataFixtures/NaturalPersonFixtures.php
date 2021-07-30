<?php

namespace App\DataFixtures;

use App\Entity\NaturalPerson;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class NaturalPersonFixtures extends Fixture implements DependentFixtureInterface
{
    public const NATURAL_PERSON_REFERENCE_1 = 'naturalPerson1';
    public const NATURAL_PERSON_REFERENCE_2 = 'naturalPerson2';
    public const NATURAL_PERSON_REFERENCE_3 = 'naturalPerson3';
    public const NATURAL_PERSON_REFERENCE_4 = 'naturalPerson4';
    public const NATURAL_PERSON_REFERENCE_5 = 'naturalPerson5';

    public function load(ObjectManager $manager)
    {
       // Création d’une natural person 1
        $naturalPerson1 = new NaturalPerson();
        $naturalPerson1->setStructureMember($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $naturalPerson1->setMainStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $naturalPerson1->setGender('M');
        $naturalPerson1->setFirstname('Yannick');
        $naturalPerson1->setLastname('COUTURIER');
        $naturalPerson1->setDateOfBirth(new \DateTime('1983-06-23'));
        $naturalPerson1->setPlaceOfBirth('Ville');
        $naturalPerson1->setEmail('yannick@juriactes.fr');
        $naturalPerson1->setTelephone('06 16 83 49 52');
        $naturalPerson1->setTelephone2('01 50 50 50 50');

        $manager->persist($naturalPerson1);

       // Création d’une natural person 2
        $naturalPerson2 = new NaturalPerson();
        $naturalPerson2->setStructureMember($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $naturalPerson2->setSecondStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $naturalPerson2->setGender('F');
        $naturalPerson2->setFirstname('Pascale');
        $naturalPerson2->setLastname('AVOCAT');
        $naturalPerson2->setDateOfBirth(new \DateTime('1978-01-12'));
        $naturalPerson2->setPlaceOfBirth('Ville');
        $naturalPerson2->setEmail('pascale@juriste.fr');
        $naturalPerson2->setTelephone('06 16 83 49 22');
        $naturalPerson2->setTelephone2('01 50 50 50 22');

        $manager->persist($naturalPerson2);

        // Création d’une natural person 3
        $naturalPerson3 = new NaturalPerson();
        $naturalPerson3->setStructureMember($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $naturalPerson3->setGender('M');
        $naturalPerson3->setFirstname('Maurice');
        $naturalPerson3->setLastname('LEROI');
        $naturalPerson3->setDateOfBirth(new \DateTime('1978-01-12'));
        $naturalPerson3->setPlaceOfBirth('Ville');
        $naturalPerson3->setEmail('mauriceleroi@gmail.com');
        $naturalPerson3->setTelephone('06 12 13 45 56');
        $naturalPerson3->setTelephone2('');

        $manager->persist($naturalPerson3);

        // Création d’une natural person 4
        $naturalPerson4 = new NaturalPerson();
        $naturalPerson4->setStructureMember($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $naturalPerson4->setGender('F');
        $naturalPerson4->setFirstname('Fabienne');
        $naturalPerson4->setLastname('PICHARD');
        $naturalPerson4->setDateOfBirth(new \DateTime('1978-01-12'));
        $naturalPerson4->setPlaceOfBirth('Ville');
        $naturalPerson4->setEmail('fpichard@ldms.com');
        $naturalPerson4->setTelephone('07 77 88 45 29');
        $naturalPerson4->setTelephone2('');

        $manager->persist($naturalPerson4);

        // Création d’une natural person 5
        $naturalPerson5 = new NaturalPerson();
        $naturalPerson5->setStructureMember($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $naturalPerson5->setGender('M');
        $naturalPerson5->setFirstname('Jean-Guy');
        $naturalPerson5->setLastname('BERTRAND');
        $naturalPerson5->setDateOfBirth(new \DateTime('1978-01-12'));
        $naturalPerson5->setPlaceOfBirth('Ville');
        $naturalPerson5->setEmail('jgb@cci.fr');
        $naturalPerson5->setTelephone('05 59 78 32 42');
        $naturalPerson5->setTelephone2('');

        $manager->persist($naturalPerson5);


        $manager->flush();

        $this->addReference(self::NATURAL_PERSON_REFERENCE_1, $naturalPerson1);
        $this->addReference(self::NATURAL_PERSON_REFERENCE_2, $naturalPerson2);
        $this->addReference(self::NATURAL_PERSON_REFERENCE_3, $naturalPerson3);
        $this->addReference(self::NATURAL_PERSON_REFERENCE_4, $naturalPerson4);
        $this->addReference(self::NATURAL_PERSON_REFERENCE_5, $naturalPerson5);
    }

    public function getDependencies()
    {
        return [
            StructureFixtures::class,
            UserFixtures::class,
            CollegeFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
