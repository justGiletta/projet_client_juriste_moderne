<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Associate;
use App\Entity\Executive;
use App\Entity\LegalPerson;
use App\Entity\NaturalPerson;
use App\Entity\OtherParticipant;
use App\Entity\Structure;
use App\Entity\User;
use App\Form\AddressType;
use App\Form\NaturalPersonType;
use App\Repository\NaturalPersonRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LegalPersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('siren', IntegerType::class, [
                'required' => false
            ])
            ->add('tradeAndCompagnyRegister', TextType::class, [
                'required' => false
            ])
            ->add('registerCapital', NumberType::class, [
                'required' => false
            ])
            ->add('companyForm', TextType::class)

            ->add('email', EmailType::class, [
                'required' => false
            ])
            ->add('telephone', TextType::class, [
                'required' => false
            ])
            ->add('telephone2', TextType::class, [
                'required' => false
            ])
            ->add('mainRepresentative', EntityType::class, [
                'required' => false,
                'class' => NaturalPerson::class,
                'query_builder' => function (NaturalPersonRepository $repo) use ($options) {
                    return $repo->findNaturalBy($options['id']);
                }
            ])
            ->add('secondRepresentative', EntityType::class, [
                'required' => false,
                'class' => NaturalPerson::class,
                'query_builder' => function (NaturalPersonRepository $repo) use ($options) {
                    return $repo->findNaturalBy($options['id']);
                }
            ])
            ->add('executive', ExecutiveType::class)
            ->add('associate', AssociateType::class)
            ->add('otherParticipant', OtherParticipantType::class)
            ->add('addresses', CollectionType::class, [
                'label' => false,
                'entry_type' => AddressType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LegalPerson::class,
            'id' => null
        ]);
        $resolver->setAllowedTypes('id', 'int');
    }
}
