<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture implements DependentFixtureInterface
{
    public const CATEGORY_REFERENCE_1_10 = 'category1_10';
    public const CATEGORY_REFERENCE_1_20 = 'category1_20';
    public const CATEGORY_REFERENCE_1_30 = 'category1_30';
    public const CATEGORY_REFERENCE_1_40 = 'category1_40';
    public const CATEGORY_REFERENCE_2 = 'category2';
    public const CATEGORY_REFERENCE_3 = 'category3';
    public const CATEGORY_REFERENCE_4 = 'category4';
    public const CATEGORY_REFERENCE_5 = 'category5';
    public const CATEGORY_REFERENCE_6 = 'category6';
    public const CATEGORY_REFERENCE_7_10 = 'category7_10';
    public const CATEGORY_REFERENCE_7_20 = 'category7_20';
    public const CATEGORY_REFERENCE_7_30 = 'category7_30';
    public const CATEGORY_REFERENCE_7_40 = 'category7_40';
    public const CATEGORY_REFERENCE_7_50 = 'category7_50';
    public const CATEGORY_REFERENCE_7_60 = 'category7_60';

    private $input;

    public function __construct(Slugify $input)
    {
        $this->input = $input;
    }

    public function load(ObjectManager $manager)
    {
       // Création d’une category 1 - 10
        $category1_10 = new Category();
        $category1_10->setName('1');
        $category1_10->setPrefixClassification('- 10');
        $category1_10->setDescription('Employé, technicien, agent de maîtrise');
        $category1_10->setSlug($this->input->generate($category1_10->getDescription()));
        $category1_10->setNbMinAction('1');
        $category1_10->setShareValue('100');
        $category1_10->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));

        $manager->persist($category1_10);

       // Création d’une category 1 - 20
        $category1_20 = new Category();
        $category1_20->setName('1');
        $category1_20->setPrefixClassification('- 20');
        $category1_20->setDescription('Cadre niv I');
        $category1_20->setSlug($this->input->generate($category1_20->getDescription()));
        $category1_20->setNbMinAction('2');
        $category1_20->setShareValue('100');
        $category1_20->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));

        $manager->persist($category1_20);

       // Création d’une category 1 - 30
        $category1_30 = new Category();
        $category1_30->setName('1');
        $category1_30->setPrefixClassification('- 30');
        $category1_30->setDescription('Cadre niv II');
        $category1_30->setSlug($this->input->generate($category1_30->getDescription()));
        $category1_30->setNbMinAction('3');
        $category1_30->setShareValue('100');
        $category1_30->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));

        $manager->persist($category1_30);

       // Création d’une category 1 - 40
        $category1_40 = new Category();
        $category1_40->setName('1');
        $category1_40->setPrefixClassification('- 40');
        $category1_40->setDescription('Cadre niv III');
        $category1_40->setSlug($this->input->generate($category1_40->getDescription()));
        $category1_40->setNbMinAction('4');
        $category1_40->setShareValue('100');
        $category1_40->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));

        $manager->persist($category1_40);


        // Création d’une category 2
        $category2 = new Category();
        $category2->setName('2');
        $category2->setPrefixClassification('- ');
        $category2->setDescription('Collectivité publique');
        $category2->setSlug($this->input->generate($category2->getDescription()));
        $category2->setNbMinAction('250');
        $category2->setShareValue('100');
        $category2->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));

        $manager->persist($category2);

        // Création d’une category 3
        $category3 = new Category();
        $category3->setName('3');
        $category3->setPrefixClassification('- ');
        $category3->setDescription('Organisme financier, assurance');
        $category3->setSlug($this->input->generate($category3->getDescription()));
        $category3->setNbMinAction('500');
        $category3->setShareValue('100');
        $category3->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));

        $manager->persist($category3);

        // Création d’une category 4
        $category4 = new Category();
        $category4->setName('4');
        $category4->setPrefixClassification('- ');
        $category4->setDescription('Expert (personnes physiques)');
        $category4->setSlug($this->input->generate($category4->getDescription()));
        $category4->setNbMinAction('2');
        $category4->setShareValue('100');
        $category4->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));

        $manager->persist($category4);

        // Création d’une category 5
        $category5 = new Category();
        $category5->setName('5');
        $category5->setPrefixClassification(
            '- '
        );
        $category5->setDescription(
            'Université, centre de recherche, centre technologique, organisme d\'enseignement'
        );
        $category5->setSlug($this->input->generate($category5->getDescription()));
        $category5->setNbMinAction('150');
        $category5->setShareValue('100');
        $category5->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));

        $manager->persist($category5);

        // Création d’une category 6
        $category6 = new Category();
        $category6->setName('6');
        $category6->setPrefixClassification('- ');
        $category6->setDescription('Grande entreprise, organisation professionnelle');
        $category6->setSlug($this->input->generate($category6->getDescription()));
        $category6->setNbMinAction('250');
        $category6->setShareValue('100');
        $category6->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));

        $manager->persist($category6);

        // Création d’une category 7_10
        $category7_10 = new Category();
        $category7_10->setName('7');
        $category7_10->setPrefixClassification('- 10');
        $category7_10->setDescription('TPE JE (immatriculation <5ans)');
        $category7_10->setSlug($this->input->generate($category7_10->getDescription()));
        $category7_10->setNbMinAction('1');
        $category7_10->setNbMaxAction('75');
        $category7_10->setShareValue('100');
        $category7_10->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));

        $manager->persist($category7_10);

        // Création d’une category 7_20
        $category7_20 = new Category();
        $category7_20->setName('7');
        $category7_20->setPrefixClassification('- 20');
        $category7_20->setDescription('PME JE (immatriculation <5ans)');
        $category7_20->setSlug($this->input->generate($category7_20->getDescription()));
        $category7_20->setNbMinAction('1');
        $category7_20->setNbMaxAction('75');
        $category7_20->setShareValue('100');
        $category7_20->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));

        $manager->persist($category7_20);

        // Création d’une category 7_30
        $category7_30 = new Category();
        $category7_30->setName('7');
        $category7_30->setPrefixClassification('- 30');
        $category7_30->setDescription('ETI JE (immatriculation <5ans)');
        $category7_30->setSlug($this->input->generate($category7_30->getDescription()));
        $category7_30->setNbMinAction('1');
        $category7_30->setNbMaxAction('75');
        $category7_30->setShareValue('100');
        $category7_30->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));

        $manager->persist($category7_30);

        // Création d’une category 7_40
        $category7_40 = new Category();
        $category7_40->setName('7');
        $category7_40->setPrefixClassification('- 40');
        $category7_40->setDescription('TPE +5ans');
        $category7_40->setSlug($this->input->generate($category7_40->getDescription()));
        $category7_40->setNbMinAction('25');
        $category7_40->setNbMaxAction('75');
        $category7_40->setShareValue('100');
        $category7_40->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));

        $manager->persist($category7_40);

        // Création d’une category 7_50
        $category7_50 = new Category();
        $category7_50->setPrefixClassification('- 50');
        $category7_50->setName('7');
        $category7_50->setDescription('PME +5ans');
        $category7_50->setSlug($this->input->generate($category7_50->getDescription()));
        $category7_50->setNbMinAction('25');
        $category7_50->setNbMaxAction('75');
        $category7_50->setShareValue('100');
        $category7_50->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));

        $manager->persist($category7_50);

        // Création d’une category 7_60
        $category7_60 = new Category();
        $category7_60->setName('7');
        $category7_60->setPrefixClassification('- 60');
        $category7_60->setDescription('ETI +5ans');
        $category7_60->setSlug($this->input->generate($category7_60->getDescription()));
        $category7_60->setNbMinAction('25');
        $category7_60->setNbMaxAction('175');
        $category7_60->setShareValue('100');
        $category7_60->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));

        $manager->persist($category7_60);


        $manager->flush();

        $this->addReference(self::CATEGORY_REFERENCE_1_10, $category1_10);
        $this->addReference(self::CATEGORY_REFERENCE_1_20, $category1_20);
        $this->addReference(self::CATEGORY_REFERENCE_1_30, $category1_30);
        $this->addReference(self::CATEGORY_REFERENCE_1_40, $category1_40);
        $this->addReference(self::CATEGORY_REFERENCE_2, $category2);
        $this->addReference(self::CATEGORY_REFERENCE_3, $category3);
        $this->addReference(self::CATEGORY_REFERENCE_4, $category4);
        $this->addReference(self::CATEGORY_REFERENCE_5, $category5);
        $this->addReference(self::CATEGORY_REFERENCE_6, $category6);
        $this->addReference(self::CATEGORY_REFERENCE_7_10, $category7_10);
        $this->addReference(self::CATEGORY_REFERENCE_7_20, $category7_20);
        $this->addReference(self::CATEGORY_REFERENCE_7_30, $category7_30);
        $this->addReference(self::CATEGORY_REFERENCE_7_40, $category7_40);
        $this->addReference(self::CATEGORY_REFERENCE_7_50, $category7_50);
        $this->addReference(self::CATEGORY_REFERENCE_7_60, $category7_60);
    }

    public function getDependencies()
    {
        return [
            StructureFixtures::class,
            UserFixtures::class,
            CollegeFixtures::class,
        ];
    }
}
