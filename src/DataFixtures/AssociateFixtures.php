<?php

namespace App\DataFixtures;

use App\Entity\Associate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AssociateFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
       // Création d’un associate 1 - Y.Couturier Associé + Président
        $associate1 = new Associate();
        $associate1->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $associate1->setNaturalPerson($this->getReference(NaturalPersonFixtures::NATURAL_PERSON_REFERENCE_1));
        $associate1->setSubscriptionDate(new \DateTime('2017-09-18'));
        $associate1->setCaApprovalDate(new \DateTime('2017-10-10'));
        $associate1->setAgApprovalDate(new \DateTime('2017-10-10'));
        $associate1->setFirstSubscribedCapitalPaymentsDate(new \DateTime('2017-09-18'));
        $associate1->setNumberOfShare('45');
        $associate1->setSubscribedCapitalAmountPaidUp('7500');
        $associate1->setWithdrawalRequestDate(null);
        $associate1->setRepaymentDate(null);
        $associate1->setRepaymentAmount(null);
        $associate1->setExpertiseField('
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Praesentium aliquid ducimus ab porro vero corrupti eum beatae incidunt odit quisquam, vel sed quia quo.
            Ipsum libero illo laboriosam expedita amet!');
        $associate1->setCategory($this->getReference(CategoryFixtures::CATEGORY_REFERENCE_1_40));
        $associate1->setCollege($this->getReference(CollegeFixtures::COLLEGE_REFERENCE_A));

        $manager->persist($associate1);

        // Création d’un associate 2 - P.Avocat Associé + Gérante
        $associate2 = new Associate();
        $associate2->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $associate2->setNaturalPerson($this->getReference(NaturalPersonFixtures::NATURAL_PERSON_REFERENCE_2));
        $associate2->setSubscriptionDate(new \DateTime('2019-01-12'));
        $associate2->setCaApprovalDate(new \DateTime('2019-03-23'));
        $associate2->setAgApprovalDate(new \DateTime('2019-03-23'));
        $associate2->setFirstSubscribedCapitalPaymentsDate(new \DateTime('2019-01-12'));
        $associate2->setNumberOfShare('2');
        $associate2->setSubscribedCapitalAmountPaidUp('400');
        $associate2->setWithdrawalRequestDate(null);
        $associate2->setRepaymentDate(null);
        $associate2->setRepaymentAmount(null);
        $associate2->setExpertiseField('
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Praesentium aliquid ducimus ab porro vero corrupti eum beatae incidunt odit quisquam, vel sed quia quo.
            Ipsum libero illo laboriosam expedita amet!');
        $associate2->setCategory($this->getReference(CategoryFixtures::CATEGORY_REFERENCE_4));
        $associate2->setCollege($this->getReference(CollegeFixtures::COLLEGE_REFERENCE_A));

        $manager->persist($associate2);

        // Création d’un associate 3 - M.LEROI Ancien Associé
        $associate3 = new Associate();
        $associate3->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $associate3->setNaturalPerson($this->getReference(NaturalPersonFixtures::NATURAL_PERSON_REFERENCE_3));
        $associate3->setSubscriptionDate(new \DateTime('2018-05-30'));
        $associate3->setCaApprovalDate(new \DateTime('2018-10-10'));
        $associate3->setAgApprovalDate(new \DateTime('2018-10-10'));
        $associate3->setFirstSubscribedCapitalPaymentsDate(new \DateTime('2018-05-31'));
        $associate3->setNumberOfShare('3');
        $associate3->setSubscribedCapitalAmountPaidUp('450');
        $associate3->setWithdrawalRequestDate(new \DateTime('2020-10-10'));
        $associate3->setRepaymentDate(new \DateTime('2020-12-22'));
        $associate3->setRepaymentAmount($associate3->getSubscribedCapitalAmountPaidUp());
        $associate3->setExpertiseField('
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Praesentium aliquid ducimus ab porro vero corrupti eum beatae incidunt odit quisquam, vel sed quia quo.
            Ipsum libero illo laboriosam expedita amet!');
        $associate3->setCategory($this->getReference(CategoryFixtures::CATEGORY_REFERENCE_4));
        $associate3->setCollege($this->getReference(CollegeFixtures::COLLEGE_REFERENCE_B));

        $manager->persist($associate3);

        // Création d’un associate 4 - F.PICHARD Associée + Administratrice
        $associate4 = new Associate();
        $associate4->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $associate4->setNaturalPerson($this->getReference(NaturalPersonFixtures::NATURAL_PERSON_REFERENCE_4));
        $associate4->setSubscriptionDate(new \DateTime('2020-09-16'));
        $associate4->setCaApprovalDate(new \DateTime('2020-10-10'));
        $associate4->setAgApprovalDate(new \DateTime('2020-10-10'));
        $associate4->setFirstSubscribedCapitalPaymentsDate(new \DateTime('2020-10-01'));
        $associate4->setNumberOfShare('2');
        $associate4->setSubscribedCapitalAmountPaidUp('320');
        $associate4->setWithdrawalRequestDate(null);
        $associate4->setRepaymentDate(null);
        $associate4->setRepaymentAmount(null);
        $associate4->setExpertiseField('
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Praesentium aliquid ducimus ab porro vero corrupti eum beatae incidunt odit quisquam, vel sed quia quo.
            Ipsum libero illo laboriosam expedita amet!');
        $associate4->setCategory($this->getReference(CategoryFixtures::CATEGORY_REFERENCE_1_10));
        $associate4->setCollege($this->getReference(CollegeFixtures::COLLEGE_REFERENCE_A));


        $manager->persist($associate4);

        // Création d’un associate 5 - JG.Bertrand pas associé + Invité
        $associate5 = new Associate();
        $associate5->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $associate5->setNaturalPerson($this->getReference(NaturalPersonFixtures::NATURAL_PERSON_REFERENCE_5));

        $manager->persist($associate5);

        // Création d’un associate 6 - SARL Les Constructions Qui Durent Associé
        $associate6 = new Associate();
        $associate6->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $associate6->setLegalPerson($this->getReference(LegalPersonFixtures::LEGAL_PERSON_REFERENCE_1));
        $associate6->setSubscriptionDate(new \DateTime('2020-09-16'));
        $associate6->setCaApprovalDate(new \DateTime('2020-10-10'));
        $associate6->setAgApprovalDate(new \DateTime('2020-10-10'));
        $associate6->setFirstSubscribedCapitalPaymentsDate(new \DateTime('2020-10-01'));
        $associate6->setNumberOfShare('26');
        $associate6->setSubscribedCapitalAmountPaidUp('3750');
        $associate6->setWithdrawalRequestDate(null);
        $associate6->setRepaymentDate(null);
        $associate6->setRepaymentAmount(null);
        $associate6->setExpertiseField('
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Praesentium aliquid ducimus ab porro vero corrupti eum beatae incidunt odit quisquam, vel sed quia quo.
            Ipsum libero illo laboriosam expedita amet!');
        $associate6->setCategory($this->getReference(CategoryFixtures::CATEGORY_REFERENCE_7_20));
        $associate6->setCollege($this->getReference(CollegeFixtures::COLLEGE_REFERENCE_D));

        $manager->persist($associate6);

        // Création d’un associate 7 - CCI de Nantes Associé sortant
        $associate7 = new Associate();
        $associate7->setStructure($this->getReference(StructureFixtures::STRUCTURE_REFERENCE_1));
        $associate7->setLegalPerson($this->getReference(LegalPersonFixtures::LEGAL_PERSON_REFERENCE_2));
        $associate7->setSubscriptionDate(new \DateTime('2020-09-16'));
        $associate7->setCaApprovalDate(new \DateTime('2020-10-10'));
        $associate7->setAgApprovalDate(new \DateTime('2020-10-10'));
        $associate7->setFirstSubscribedCapitalPaymentsDate(new \DateTime('2020-11-15'));
        $associate7->setNumberOfShare('250');
        $associate7->setSubscribedCapitalAmountPaidUp('42350');
        $associate7->setWithdrawalRequestDate(new \DateTime('2022-01-28'));
        $associate7->setRepaymentDate(null);
        $associate7->setRepaymentAmount(null);
        $associate7->setExpertiseField('
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Praesentium aliquid ducimus ab porro vero corrupti eum beatae incidunt odit quisquam, vel sed quia quo.
            Ipsum libero illo laboriosam expedita amet!');
        $associate7->setCategory($this->getReference(CategoryFixtures::CATEGORY_REFERENCE_2));
        $associate7->setCollege($this->getReference(CollegeFixtures::COLLEGE_REFERENCE_F));

        $manager->persist($associate7);



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
        ];
    }
}
