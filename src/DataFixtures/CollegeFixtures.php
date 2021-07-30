<?php

namespace App\DataFixtures;

use App\Entity\College;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CollegeFixtures extends Fixture implements DependentFixtureInterface
{
    public const COLLEGE_REFERENCE_A = 'collegeA';
    public const COLLEGE_REFERENCE_B = 'collegeB';
    public const COLLEGE_REFERENCE_C = 'collegeC';
    public const COLLEGE_REFERENCE_D = 'collegeD';
    public const COLLEGE_REFERENCE_E = 'collegeE';
    public const COLLEGE_REFERENCE_F = 'collegeF';
    public const COLLEGE_REFERENCE_G = 'collegeG';
    public const COLLEGE_REFERENCE_H = 'collegeH';

    private $input;

    public function __construct(Slugify $input)
    {
        $this->input = $input;
    }

    public function load(ObjectManager $manager)
    {
       // Création d’une college A
        $collegeA = new College();
        $collegeA->setName('A');
        $collegeA->setPrefixClassification('Membres fondateurs');
        $collegeA->setSlug($this->input->generate($collegeA->getPrefixClassification()));
        $collegeA->setDescription('Vote');
        $collegeA->setNbVotingRight('15.0');
        $collegeA->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));

        $manager->persist($collegeA);

       // Création d’une college B
        $collegeB = new College();
        $collegeB->setName('B');
        $collegeB->setPrefixClassification('Personnes physiques');
        $collegeB->setSlug($this->input->generate($collegeB->getPrefixClassification()));
        $collegeB->setDescription('Vote consultatif');
        $collegeB->setNbVotingRight('10.0');
        $collegeB->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));

        $manager->persist($collegeB);

       // Création d’une college C
        $collegeC = new College();
        $collegeC->setName('C');
        $collegeC->setPrefixClassification('Salariés');
        $collegeC->setSlug($this->input->generate($collegeC->getPrefixClassification()));
        $collegeC->setDescription('Vote consultatif');
        $collegeC->setNbVotingRight('10.0');
        $collegeC->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));

        $manager->persist($collegeC);

       // Création d’une college D
        $collegeD = new College();
        $collegeD->setName('D');
        $collegeD->setPrefixClassification('TPE, PME');
        $collegeD->setSlug($this->input->generate($collegeD->getPrefixClassification()));
        $collegeD->setDescription('Vote');
        $collegeD->setNbVotingRight('15.0');
        $collegeD->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));

        $manager->persist($collegeD);

       // Création d’une college E
        $collegeE = new College();
        $collegeE->setName('E');
        $collegeE->setPrefixClassification('Organismes financiers et grandes entreprises');
        $collegeE->setSlug($this->input->generate($collegeE->getPrefixClassification()));
        $collegeE->setDescription('Vote');
        $collegeE->setNbVotingRight('15.0');
        $collegeE->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));

        $manager->persist($collegeE);

       // Création d’une college F
        $collegeF = new College();
        $collegeF->setName('F');
        $collegeF->setPrefixClassification('Collectivités');
        $collegeF->setSlug($this->input->generate($collegeF->getPrefixClassification()));
        $collegeF->setDescription('Vote');
        $collegeF->setNbVotingRight('10.0');
        $collegeF->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));

        $manager->persist($collegeF);

       // Création d’une college G
        $collegeG = new College();
        $collegeG->setName('G');
        $collegeG->setPrefixClassification(
            'Universités, centres de recherches, centres technologiques, organismes d’enseignement'
        );
        $collegeG->setSlug($this->input->generate($collegeG->getPrefixClassification()));
        $collegeG->setDescription('Vote consultatif');
        $collegeG->setNbVotingRight('15');
        $collegeG->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));

        $manager->persist($collegeG);

       // Création d’une college H
        $collegeH = new College();
        $collegeH->setName('H');
        $collegeH->setPrefixClassification('Maîtres ouvrage, maîtres d’œuvre');
        $collegeH->setDescription('Vote consultatif');
        $collegeH->setSlug($this->input->generate($collegeH->getPrefixClassification()));
        $collegeH->setNbVotingRight('10.0');
        $collegeH->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));

        $manager->persist($collegeH);


        $manager->flush();

        $this->addReference(self::COLLEGE_REFERENCE_A, $collegeA);
        $this->addReference(self::COLLEGE_REFERENCE_B, $collegeB);
        $this->addReference(self::COLLEGE_REFERENCE_C, $collegeC);
        $this->addReference(self::COLLEGE_REFERENCE_D, $collegeD);
        $this->addReference(self::COLLEGE_REFERENCE_E, $collegeE);
        $this->addReference(self::COLLEGE_REFERENCE_F, $collegeF);
        $this->addReference(self::COLLEGE_REFERENCE_H, $collegeH);
    }

    public function getDependencies()
    {
        return [
            StructureFixtures::class,
            UserFixtures::class,
        ];
    }
}
