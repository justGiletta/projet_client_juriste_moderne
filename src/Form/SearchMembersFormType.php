<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Structure;
use App\Repository\AssociateRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchMembersFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('search', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Nom',
                ]
            ])
            ->add("roles", ChoiceType::class, [
                'label' => false,
                'required' => false,
                'placeholder' => 'Filtrer par rôle',
                'choices' => [
                    'Associé' => 'Associé',
                    'Associé sortant' => 'Associé sortant',
                    'Ancien associé' => 'Ancien associé',
                    'Exécutif' => 'Exécutif',
                    'Autres' => 'Autres'
                ]
            ])
            ->add("page", HiddenType::class, [
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }
    public function getBlockPrefix(): string
    {
        return '';
    }
}
