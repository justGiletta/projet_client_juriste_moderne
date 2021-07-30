<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\NaturalPerson;
use App\Entity\Structure;
use App\Repository\AddressRepository;
use App\Repository\NaturalPersonRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StructureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('siren', IntegerType::class, [
                'required' => false
            ])
            ->add('tradeAndCompanyRegister', TextType::class)
            ->add('registeredCapital', NumberType::class)
            ->add('companyForm', TextType::class)
            ->add('email', TextType::class)
            ->add('telephone', TextType::class)
            ->add('telephone2', TextType::class)
            ->add('description', TextareaType::class)
            ->add('addresses', CollectionType::class, [
                'entry_type' => AddressType::class,
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('mainRepresentative', EntityType::class, [
                'class' => NaturalPerson::class,
                'query_builder' => function (NaturalPersonRepository $er) {
                    return $er->createQueryBuilder('np')
                        ->select('np')
                        ->join('np.structureMember', 's')
                        ->addSelect('s')
                        ->where('np.structureMember = s.id');
                },
            ])
            ->add('secondRepresentative', EntityType::class, [
                'class' => NaturalPerson::class,
                'query_builder' => function (NaturalPersonRepository $er) {
                    return $er->createQueryBuilder('np')
                        ->select('np')
                        ->join('np.structureMember', 's')
                        ->addSelect('s')
                        ->where('np.structureMember = s.id');
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Structure::class,
        ]);
    }
}
