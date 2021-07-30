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
use App\Repository\LegalPersonRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NaturalPersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender', ChoiceType::class, [
                'choices'  => [
                    'Homme' => 'm',
                    'Femme' => 'f'
                ]
            ])
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('dateOfBirth', DateType::class, [
                'widget' => 'single_text',
                'required' => false
            ])

            ->add('placeOfBirth', TextType::class, [
                'required' => false
            ])
            ->add('email', EmailType::class, [
                'required' => false
            ])
            ->add('telephone', TelType::class, [
                'required' => false
            ])
            ->add('telephone2', TelType::class, [
                'required' => false
            ])
            ->add('addresses', CollectionType::class, [
                'label' => false,
                'entry_type' => AddressType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('executive', ExecutiveType::class)
            ->add('associate', AssociateType::class)
            ->add('otherParticipant', OtherParticipantType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NaturalPerson::class,
        ]);
    }
}
